<?php

namespace App\Models\Orders;

use App\Enums\OrderStatusEnum;
use App\Models\Certificate;
use App\Models\Lounges\Lounge;
use App\Models\Lounges\LoungeSchedule;
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
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Order extends Model
{
    use HasTimestamps;

    public static array $packageOptions = ['Комфорт', 'Стандарт', 'Эконом'];

    // TODO: Must be refactored in the future
    protected $fillable = [
        'quest_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'date',
        'price',
        'price_players',
        'price_options',
        'certificate_id',
        'payed_cash',
        'payed_card',
        'payed_online',
        'source',
        'status',
        'comment',
        'promo',
        'discount_value',
        'blocking',
        'fact_payment',
        'prepayed',
        'tech_prod_id',
        'prepayed_type',
        'fact_payment_type',
        'price_total',
        'checkout_type_id',
        'payed_aggregator',
        'package',
        'countPlayers',
        'lounge_id',
        'lounge_schedule_id',
        'certificate_data_id',
        'additional_players',
        'lounge_schedule_item_id'
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

    public function date(): Attribute
    {
        return $this->getTimeMutator();
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
        return $this->belongsToMany(OrderOption::class, 'orders_order_option')->using(OrderQuestOption::class);
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
        return $this->belongsTo(Sale::class, 'promo', 'promocode');
    }
}
