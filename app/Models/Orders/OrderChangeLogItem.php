<?php

namespace App\Models\Orders;

use App\Models\ChangeLogItem;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderChangeLogItem extends ChangeLogItem
{
   public function __construct(array $attributes = [])
   {
       parent::__construct($attributes);
       $this->fillable[] = 'order_id';
   }

   public function order(): BelongsTo
   {
       return $this->belongsTo(Order::class);
   }

   public function user(): BelongsTo
   {
       return $this->belongsTo(User::class);
   }
}
