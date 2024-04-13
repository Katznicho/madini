<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'phone_number',
        'payment_mode',
        'payment_method',
        'description',
        'reference',
        'status',
        'order_tracking_id',
        'OrderNotificationType',
        'cooperative_id', 
        'user_id',
        'order_id'

        
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cooperative()
    {
        return $this->belongsTo(Cooperative::class);
    }

}
