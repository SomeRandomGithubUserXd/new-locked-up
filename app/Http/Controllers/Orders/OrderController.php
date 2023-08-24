<?php

namespace App\Http\Controllers\Orders;

use App\Enums\Acquiring\AcquiringCurrencyEnum;
use App\Enums\Acquiring\AcquiringProviderEnum;
use App\Enums\Orders\OrderPaymentStatusEnum;
use App\Enums\Orders\OrderPaymentTypeEnum;
use App\Enums\UserRoleEnum;
use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Orders\ChangeStatusRequest;
use App\Http\Requests\Orders\FilterRequest;
use App\Http\Requests\Orders\OrderRequest;
use App\Http\Requests\Orders\StoreQuestRequest;
use App\Http\Resources\Orders\LogsResource;
use App\Http\Resources\Orders\OrderMetaResource;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Certificates\Certificate;
use App\Models\Orders\Order;
use App\Models\Orders\OrderFilter;
use App\Models\Orders\OrderOption;
use App\Models\Orders\OrderPayment;
use App\Models\Orders\OrderSource;
use App\Models\Quests\Quest;
use App\Models\Sales\Sale;
use App\Services\Acquiring\AcquiringService;
use App\Traits\InteractsWithOrders;
use App\Traits\QueryTools;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;

class OrderController extends AbstractControllerWithMultipleDeletion
{
    use InteractsWithOrders, QueryTools;

    public function index(FilterRequest $request, $justTheQuery = false)
    {
        $query = Order::query()->with('orderOptions');
        $orderOptionQuery = OrderOption::query();
        if (auth()->user()->role === UserRoleEnum::admin || auth()->user()->role === UserRoleEnum::callCenter) {
            $quests = Quest::whereIn('location_id', auth()->user()->locations()->pluck('locations.id'));
            $query->whereIn('quest_id', $quests->pluck('id'));
            $orderOptionQuery->whereHas('orders', function ($query) use ($quests) {
                $query->whereIn('quest_id', $quests->pluck('id'));
            });
        }
        $query = $this->applyQueryFilter($query, $request);
        if ($justTheQuery) {
            return $query;
        } else {
            $queryClone = clone $query;
            return inertia('Orders/Index', [
                'orders' => OrderResource::collection($query->paginate(15)),
                'filters' => OrderFilter::get()->makeHidden(['created_at', 'updated_at']),
                'ordersMeta' => OrderMetaResource::getAsArray($queryClone),
                'options' => $orderOptionQuery
                    ->whereHas('orders', function ($query) use ($request) {
                        return $this->applyQueryFilter($query, $request);
                    })
                    ->withCount(['orders' => function ($query) use ($request) {
                        return $this->applyQueryFilter($query, $request);
                    }])
                    ->paginate(15),
                ...$this->getOrderMisc()
            ]);
        }
    }

    protected function applyQueryFilter($query, FilterRequest $request)
    {
        return $query->orderBy('orders.created_at', 'desc')
            ->when($request->search_string, function (Builder $query) use ($request) {
                return $this
                    ->getWhereLikeManyQuery(
                        $query,
                        ['orders.id', 'customer_name', 'customer_phone', 'customer_email'],
                        $request->get('search_string')
                    );
            })->when($request->date_from, static function (Builder $query) use ($request) {
                $query->where('date', '>=', $request->get('date_from'));
            })->when($request->date_to, static function (Builder $query) use ($request) {
                $query->where('date', '<=', (new Carbon($request->get('date_to')))->addDay()->format('Y-m-d'));
            })->when($request->order_id, static function (Builder $query) use ($request) {
                $query->where(['id' => $request->get('order_id')]);
            })->when($request->quest_ids, static function (Builder $query) use ($request) {
                $query->whereIn('quest_id', $request->get('quest_ids'));
            })->when($request->source_ids, static function (Builder $query) use ($request) {
                $query->whereIn('order_source_id', $request->get('source_ids'));
            })->when($request->promo_code_ids, static function (Builder $query) use ($request) {
                $promoCodes = Sale::query()
                    ->whereIn('id', $request->get('promo_code_ids'))
                    ?->pluck('promo_code');
                $query->whereIn('promo_code', $promoCodes);
            })->when($request->statuses, static function (Builder $query) use ($request) {
                $query->whereIn('status', $request->get('statuses'));
            })->when($request->with_options_only, static function (Builder $query) {
                $query->whereHas('orderOptions');
            });
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

    public function store(StoreQuestRequest $request)
    {
        $order = Order::create($request->validated());
        try {
            \DB::table('booked_date_schedule_item')->insert([
                'date' => $request->get('date') ?: Carbon::now()->format('Y-m-d'),
                'schedule_item_id' => $request->schedule_item_id,
                'order_id' => $order->id,
            ]);
        } catch (QueryException) {
        }
        $this->syncOrderPayments($order, $request->get('order_payments'));
        $order->orderOptions()->sync(collect($request->get('options'))->pluck('id'));
        $order->loungeScheduleItems()->sync($this->getLoungeScheduleItemsToSync($request->get('lounge_schedule_items')));
        return redirect()->route('orders.index');
    }

    public function update(Order $order, OrderRequest $request)
    {
        if (auth()->user()->role === UserRoleEnum::admin || auth()->user()->role === UserRoleEnum::callCenter) {
            $date = clone $order->date;
            abort_if((new Carbon())->greaterThanOrEqualTo($date->addDay()), 403);
        }
        $order->update($request->validated());
        \DB::table('booked_date_schedule_item')->where([
            'date' => $order->date->format('Y-m-d'),
            'order_id' => $order->id,
        ])->update([
            'schedule_item_id' => $request->schedule_item_id,
            'date' => $request->get('date') ?: Carbon::now()->format('Y-m-d')
        ]);
        $this->syncOrderPayments($order, $request->get('order_payments'));
        $order->loungeScheduleItems()->sync($this->getLoungeScheduleItemsToSync($request->get('lounge_schedule_items')));
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

    public function stats(FilterRequest $request)
    {
        $friendSourceIds = OrderSource::query()
            ->where('name', '==', 'Игры для друзей')
            ->pluck('id');
        $aggregatorSourceIds = OrderSource::query()
            ->where(['is_aggregator' => 1])
            ->pluck('id');
        $applyFiltersClosure = function ($query) use ($request) {
            return $this->applyQueryFilter($query, $request);
        };
        return inertia('Orders/Stats', [
            'orders' => [
                'main' => $this->index($request, true)
                    ->whereNotIn('order_source_id', $friendSourceIds->toArray() + $aggregatorSourceIds->toArray())
                    ->sum('price_total'),
                'for_friends' => $this->index($request, true)
                    ->whereIn('order_source_id', $friendSourceIds)
                    ->sum('price'),
                'aggregator' =>
                    $this->index($request, true)
                        ->whereIn('order_source_id', $aggregatorSourceIds)
                        ->sum('price'),
                'left_to_pay' =>
                    $this->index($request, true)
                        ->selectRaw('SUM(postpaid - pre_paid - paid_through_acquiring - paid_through_aggregator) as "sum"')
                        ->first()
                        ->toArray()['sum'],
            ],
            'paid' => [
                'aggregator' => $this->index($request, true)->sum('paid_through_aggregator'),
                'online' => $this->index($request, true)->sum('paid_through_acquiring'),
                'cert' => $this->index($request, true)->sum('paid_through_acquiring'),
            ],
            'sources' => OrderSource::query()
                ->whereIn('id', $aggregatorSourceIds)
                ->whereHas('orders', $applyFiltersClosure)
                ->withSum(
                    ['orders' => $applyFiltersClosure],
                    'price'
                )
                ->withSum(
                    ['orders' => $applyFiltersClosure],
                    'paid_through_aggregator'
                )
                ->paginate(15),
            'certificates' => Certificate::query()
                ->whereHas('order', $applyFiltersClosure)
                ->with('order', $applyFiltersClosure)
                ->paginate(15),
            'sales' => Sale::query()
                ->whereHas('orders', $applyFiltersClosure)
                ->withSum(
                    ['orders' => $applyFiltersClosure],
                    'price'
                )
                ->withCount('orders')
                ->paginate(15),
            'options' => OrderOption::query()
                ->whereHas('orders', $applyFiltersClosure)
                ->withCount('orders')
                ->paginate(15),
            ...$this->getOrderMisc()
        ]);
    }

    public function changeStatus(ChangeStatusRequest $request, Order $order)
    {
        $order->update(['status' => $request->get('status')]);
        return redirect()->back();
    }

    protected function syncOrderPayments(Order $order, array $payments)
    {
        foreach ($payments as $orderPayment) {
            $orderPayment['sum'] = (float)$orderPayment['sum'] * 100;
            if ($orderPayment['type'] != OrderPaymentTypeEnum::paid_through_acquiring->value && $orderPayment['status'] !== OrderPaymentStatusEnum::refunded->value) {
                $orderPayment['status'] = OrderPaymentStatusEnum::paid;
            }
            if ($existingPayment = OrderPayment::find($orderPayment['id'])) {
                $applyReturn = isset($orderPayment['apply_refund']) && $orderPayment['apply_refund'] === true;
                if (!$applyReturn) {
                    $orderPayment['returned'] = $existingPayment->returned;
                    OrderPayment::find($orderPayment['id'])->update($orderPayment);
                } else {
                    \DB::transaction(function () use ($orderPayment, $existingPayment) {
                        $orderPayment['status'] = OrderPaymentStatusEnum::refunded;

                        // TODO: recheck
                        if ($orderPayment['type'] === OrderPaymentTypeEnum::paid_through_acquiring->value) {
                            // $orderPayment['returned']
                            //            $service = new AcquiringService($order = $orderPayment->order, AcquiringProviderEnum::sberBank);
                            //            $service->getAcquiringEntity()->refund($orderPayment);
                        }

                        OrderPayment::find($orderPayment['id'])->update($orderPayment);
                    });
                }
            } else {
                OrderPayment::create($orderPayment);
            }
        }
    }

    protected function getLoungeScheduleItemsToSync(Collection|array|null $items = [])
    {
        if ($items === null) return [];
        $toSync = [];
        foreach ($items as $item) {
            $toSync[$item['id']] = ['lounge_id' => $item['pivot']['lounge_id']];
        }
        return $toSync;
    }
}
