<?php

namespace App\Models\Sales;

use App\Enums\Certificates\CertificateInstanceTypeEnum;
use App\Models\Quests\Quest;
use App\Models\SaleQuests;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        'promocode',
        'value',
        'type',
        'create_date',
        'best_before',
        'tech_prod_id',
        'start_date',
        'is_deleted',
        'for_certificate',
        'weekday_only',
        'for_aggregators',
    ];

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
            'sales_id',
            'quests_id'
        )->using(SaleQuest::class);
    }
}
