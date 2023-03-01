<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    public $timestamps = false;

    public function quests() {
        return $this->hasMany(SaleQuests::class, "sales_id", "id");
    }
}
