<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

   protected $fillable = [
       'user_id',
       'total_cost',
       'purchase_cost',
       'delivery_cost',
       'quantity',
       'status',
       'delivery_address_id',
   ];

   public function user()
   {
       return $this->belongsTo(User::class);
   }

   public function items()
   {
       return $this->hasMany(OrderItem::class);
   }

   public function deliveryAddress()
   {
       return $this->belongsTo(DeliveryAddress::class);
   }

   public function cooperative()
   {
       return $this->belongsTo(Cooperative::class);
   }
}
