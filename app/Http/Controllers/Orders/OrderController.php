<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Orders\FilterRequest;
use App\Http\Requests\Orders\OrderRequest;
use App\Http\Resources\Orders\LogsResource;
use App\Http\Resources\Orders\OrderMetaResource;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Orders\Order;
use App\Models\Orders\OrderChangeLogItem;
use App\Models\Orders\OrderFilter;
use App\Models\Sales\Sale;
use App\Models\Schedules\ScheduleItem;
use App\Traits\InteractsWithOrders;
use App\Traits\QueryTools;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use ZipStream\Exception;

class OrderController extends AbstractControllerWithMultipleDeletion
{
    use InteractsWithOrders, QueryTools;

    public function index(FilterRequest $request)
    {
        $query = Order::query()
            ->with('orderOptions')
            ->when($request->search_string, function (Builder $query) use ($request) {
                return $this
                    ->getWhereLikeManyQuery(
                        $query,
                        ['id', 'customer_name', 'customer_phone', 'customer_email'],
                        $request->get('search_string')
                    );
            })
            ->when($request->date_from, static function (Builder $query) use ($request) {
                $query->where('date', '>=', strtotime($request->get('date_from')));
            })
            ->when($request->date_to, static function (Builder $query) use ($request) {
                $query->where('date', '<=', strtotime($request->get('date_to')));
            })
            ->when($request->order_id, static function (Builder $query) use ($request) {
                $query->where(['id' => $request->get('order_id')]);
            })
            ->when($request->quest_ids, static function (Builder $query) use ($request) {
                $query->whereIn('quest_id', $request->get('quest_ids'));
            })
            ->when($request->source_ids, static function (Builder $query) use ($request) {
                $query->whereIn('source', $request->get('source_ids'));
            })
            ->when($request->promo_code_ids, static function (Builder $query) use ($request) {
                $promoCodes = Sale::query()
                    ->whereIn('id', $request->get('promo_code_ids'))
                    ->where(['is_deleted' => 0])
                    ?->pluck('promocode');
                $query->whereIn('promo', $promoCodes);
            })
            ->when($request->statuses, static function (Builder $query) use ($request) {
                $query->whereIn('status', $request->get('statuses'));
            })
            ->when($request->order_by, static function (Builder $query) use ($request) {
                $params = explode('_', $request->get('order_by'));
                if ($params[0] === 'time') $params[0] = 'date';
                $query->orderBy($params[0], $params[1]);
            }, static function (Builder $query) use ($request) {
                $query->orderBy('date', 'desc');
            })
            ->when($request->with_options_only, static function (Builder $query) {
                $query->whereHas('orderOptions');
            })
            ->paginate(15);
        return inertia('Orders/Index', [
            'orders' => OrderResource::collection($query),
            'filters' => OrderFilter::get()->makeHidden(['created_at', 'updated_at']),
            'ordersMeta' => OrderMetaResource::getAsArray(),
            ...$this->getOrderMisc()
        ]);
    }

    public function create()
    {
        return inertia('Orders/Create', $this->getOrderMisc());
    }

    public function show(Order $order)
    {
        return inertia('Orders/Show', [
            'order' => OrderResource::singleItem($order),
            ...$this->getOrderMisc()
        ]);
    }

    public function store(OrderRequest $request)
    {
        $order = Order::create($request->getUnRefactoredValidatedData());
        try {
            \DB::table('booked_date_schedule_item')->insert([
                'date' => $request->get('date') ?: Carbon::now()->format('Y-m-d'),
                'schedule_item_id' => $request->schedule_item_id,
                'order_id' => $order->id,
            ]);
        } catch (QueryException) {}
        $order->orderOptions()->sync(collect($request->get('options'))->pluck('id'));
        return redirect()->route('orders.index');
    }

    public function update(Order $order, OrderRequest $request)
    {
        $order->update($request->getUnRefactoredValidatedData());
        \DB::table('booked_date_schedule_item')->where([
            'date' => $order->date->format('Y-m-d'),
            'order_id' => $order->id,
        ])->update([
            'schedule_item_id' => $request->schedule_item_id,
            'date' => $request->get('date') ?: Carbon::now()->format('Y-m-d')
        ]);
        $order->orderOptions()->sync(collect($request->get('options'))->pluck('id'));
        return redirect()->route('orders.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        Order::whereIn('id', $request->get('ids'))->delete();
        return redirect()->back();
    }

    public function viewLogs(Order $order)
    {
        return inertia('Orders/ViewLogs', [
            'logs' => LogsResource::collection($order->orderChangeLogItems()->paginate(20))
        ]);
    }
}
