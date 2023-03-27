<?php

namespace App\Http\Controllers;

use App\Enums\Certificates\CertificateInstanceTypeEnum;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Sales\SaleRequest;
use App\Http\Resources\Sale\SaleResource;
use App\Models\Quests\Quest;
use App\Models\Sales\Sale;
use App\Traits\InteractsWithSales;
use Illuminate\Http\RedirectResponse;
use ReflectionException;

class SaleController extends AbstractControllerWithMultipleDeletion
{
    use InteractsWithSales;

    public function index()
    {
        return inertia('Sales/Index', [
            'sales' => SaleResource::collection(Sale::paginate(15))
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
        $data = $request->getUnRefactoredValidatedData();
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
        $data = $request->getUnRefactoredValidatedData();
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
