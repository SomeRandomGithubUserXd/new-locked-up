<?php

namespace App\Http\Controllers\Orders;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Orders\FilterRequest;
use App\Http\Requests\Orders\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Orders\Order;
use App\Models\Orders\OrderOption;
use App\Models\Quest;
use App\Models\Sale;
use App\Traits\InteractsWithOrders;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    use InteractsWithOrders;

    public function index(FilterRequest $request)
    {
        $query = Order::query()
            ->with('orderOptions')
            ->when($request->date_from, static function (Builder $query) use ($request) {
                $query->where('date', '>=', strtotime($request->get('date_from')));
            })
            ->when($request->date_to, static function (Builder $query) use ($request) {
                $query->where('date', '<=', strtotime($request->get('date_to')));
            })
            ->when($request->order_id, static function (Builder $query) use ($request) {
                $query->where(['id' => $request->get('order_id')]);
            })
            ->when($request->quest_id, static function (Builder $query) use ($request) {
                $query->where(['quest_id' => $request->get('quest_id')]);
            })
            ->when($request->source_id, static function (Builder $query) use ($request) {
                $query->where(['source' => $request->get('source_id')]);
            })
            ->when($request->status, static function (Builder $query) use ($request) {
                $query->where(['status' => $request->get('status')]);
            })
            ->when($request->promo_code_id, static function (Builder $query) use ($request) {
                $query->where(['promo' => Sale::firstWhere(['id' => $request->get('promo_code_id'), 'is_deleted' => 0])?->promocode]);
            })
            ->when($request->order_by, static function (Builder $query) use ($request) {
                $params = explode('_', $request->get('order_by'));
                if ($params[0] === 'time') $params[0] = 'date';
                $query->orderBy($params[0], $params[1]);
            })
            ->when($request->with_options_only, static function (Builder $query) {
                $query->whereHas('orderOptions');
            })
            ->paginate(15);
        return inertia('Orders/Index', [
            'orders' => OrderResource::collection($query),
            ...$this->getOrderMisc()
        ]);
    }

    public function create()
    {
        return inertia('Orders/Create', $this->getOrderMisc());
    }

    public function show(Order $order)
    {
        return inertia('Orders/Update', [
            'order' => OrderResource::singleItem($order),
            ...$this->getOrderMisc()
        ]);
    }

    public function store(OrderRequest $request)
    {
        $order = Order::create($request->getUnRefactoredValidatedData());
        // TODO: mb pluck them on the front
        $order->orderOptions()->sync(collect($request->get('options'))->pluck('id'));
        return redirect()->route('orders.index');
    }

    public function update(Order $order, OrderRequest $request)
    {
        $order->update($request->getUnRefactoredValidatedData());
        $order->orderOptions()->sync(collect($request->get('options'))->pluck('id'));
        return redirect()->route('orders.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        Order::whereIn('id', $request->get('ids'))->delete();
        return redirect()->back();
    }
}
