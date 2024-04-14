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

    //a product belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //a product belongs to a cooperative
    public function cooperative()
    {
        return $this->belongsTo(Cooperative::class);
    }
}
