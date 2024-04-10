<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'description' => 'array',
    ];
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'category_id',
        'cooperative_id',
        'status',
    ];
}
