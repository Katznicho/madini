<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'profile_picture',
        'gender',
        'address',
        'account_number',
        'status',
        'pin',
        'pin_recovery',
        'pin_reset',
        'cooperative_id',   
    ];
}

