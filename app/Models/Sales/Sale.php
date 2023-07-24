<?php

namespace App\Models\Sales;

use App\Enums\Certificates\CertificateInstanceTypeEnum;
use App\Models\Orders\Order;
use App\Models\Quests\Quest;
use App\Models\SaleQuests;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = ['promo_code', 'value', 'type', 'activation_date', 'best_before', 'for_certificates', 'for_aggregators', 'weekdays_only'];

    public $timestamps = false;

    protected $casts = [
        'type' => CertificateInstanceTypeEnum::class,
        'start_date' => 'datetime',
        'best_before' => 'datetime',
    ];

    public function quests(): BelongsToMany
    {
        return $this->belongsToMany(
            Quest::class, 'sales_quests',
            'sale_id',
            'quest_id'
        )->using(SaleQuest::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'promo_code', 'promo_code');
    }
}
