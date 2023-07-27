<?php

namespace App\Http\Controllers;

use App\Enums\Certificates\CertificateInstanceTypeEnum;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Sales\FilterRequest;
use App\Http\Requests\Sales\SaleRequest;
use App\Http\Resources\Sale\SaleResource;
use App\Models\Quests\Quest;
use App\Models\Sales\Sale;
use App\Traits\InteractsWithSales;
use App\Traits\QueryTools;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\RedirectResponse;
use ReflectionException;

class SaleController extends AbstractControllerWithMultipleDeletion
{
    use InteractsWithSales, QueryTools;

    /**
     * @throws ReflectionException
     */
    public function index(FilterRequest $request)
    {
        $sales = Sale::query()
            ->when($request->get('search_string'), function (Builder $query) use ($request) {
                return $this
                    ->getWhereLikeManyQuery(
                        $query,
                        ['promo_code', 'value', 'activation_date', 'best_before'],
                        $request->get('search_string')
                    );
            })
            ->when($request->get('promo_code'), function (Builder $query) use ($request) {
                $query->where('promo_code', 'like', '%' . $request->get('promo_code') . '%');
            })
            ->when($request->get('value'), function (Builder $query) use ($request) {
                $query->where(['value' => $request->get('value')]);
            })
            ->when($request->get('type'), function (Builder $query) use ($request) {
                $query->where(['type' => $request->get('type')]);
            })
            ->when($request->get('best_before'), function (Builder $query) use ($request) {
                $query->whereDate('best_before', '>=', $request->get('best_before'));
            })
            ->when($request->get('activation_date'), function (Builder $query) use ($request) {
                $query->whereDate('activation_date', '>=', $request->get('activation_date'));
            })
            ->when($request->get('weekdays_only'), function (Builder $query) use ($request) {
                $query->where(['weekdays_only' => define_as_bool($request->get('weekdays_only'))]);
            })
            ->when($request->get('quest_ids'), function (Builder $query) use ($request) {
                $questsCondition = function ($query) use ($request) {
                    return $query->whereIn('quests.id', $request->get('quest_ids'));
                };
                $query->whereHas('quests', $questsCondition)
                    ->with('quests', $questsCondition);
            })
            ->paginate(15);
        return inertia('Sales/Index', [
            'sales' => SaleResource::collection($sales),
            ...$this->getSalesMisc()
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function create()
    {
        return inertia('Sales/Create', $this->getSalesMisc());
    }

    public function store(SaleRequest $request)
    {
        $data = $request->validated();
        $questIds = $data['quest_ids'];
        unset($data['quest_ids']);
        $sale = Sale::create($data);
        $sale->quests()->sync($questIds);
        return redirect()->route('sales.index');
    }

    /**
     * @throws ReflectionException
     */
    public function show(Sale $sale)
    {
        return inertia('Sales/Show', [
            'sale' => SaleResource::singleItem($sale),
            ...$this->getSalesMisc()
        ]);
    }

    public function update(SaleRequest $request, Sale $sale)
    {
        $data = $request->validated();
        $questIds = $data['quest_ids'];
        unset($data['quest_ids']);
        $sale->update($data);
        $sale->quests()->sync($questIds);
        return redirect()->route('sales.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        Sale::whereIn('id', $request->get('ids'))->delete();
        return redirect()->back();
    }
}
