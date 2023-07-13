<?php

namespace App\Models\Orders;

use App\Enums\OrderStatusEnum;
use App\Models\Certificates\Certificate;
use App\Models\Lounges\LoungeScheduleItem;
use App\Models\Quests\Quest;
use App\Models\Sales\Sale;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleItem;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Order extends Model
{
    use HasTimestamps;

    public static array $packageOptions = ['Комфорт', 'Стандарт', 'Эконом'];

    protected $fillable = [
        'quest_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'date',
        'time',
        'price',
        'additional_players_cost',
        'additional_options_cost',
        'certificate_id',
        'sale_id',
        'discount',
        'pre_payed',
        'pre_payed_type',
        'postpaid',
        'postpaid_type',
        'paid_in_cash',
        'paid_via_card',
        'paid_through_acquiring',
        'paid_through_aggregator',
        'checkout_id',
        'price_total',
        'order_source_id',
        'status',
        'comment',
    ];

    protected $casts = [
        'status' => OrderStatusEnum::class
    ];

    public function status(): Attribute
    {
        return Attribute::make(
            set: static fn(int $value) => $value ?? 0,
        );
    }

    public function priceToPay(): Attribute
    {
        return Attribute::make(
            set: static function (int $val) {
                return 500;
            },
        );
    }

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }

    public function scheduleItems(): HasManyThrough
    {
        return $this->hasManyThrough(ScheduleItem::class, Schedule::class);
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(OrderSource::class, 'source', 'id');
    }

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class, 'certificate_data_id', 'id');
    }

    public function orderOptions(): BelongsToMany
    {
        return $this->belongsToMany(OrderOption::class, 'order_order_options')->using(OrderQuestOption::class);
    }

    public function loungeScheduleItem(): BelongsTo
    {
        return $this->belongsTo(LoungeScheduleItem::class, 'lounge_schedule_item_id');
    }

    public function orderChangeLogItems(): HasMany
    {
        return $this->hasMany(OrderChangeLogItem::class, 'order_id');
    }

    public function orderPayments(): HasMany
    {
        return $this->hasMany(OrderPayment::class, 'order_id');
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}
