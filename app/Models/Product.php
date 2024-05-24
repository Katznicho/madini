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

    // public function getImageUrlAttribute($value)
    // {
    //     $imagePath = $this->attributes['image'];
    //     return $imagePath ? "http://127.0.0.1:8001/storage/{$imagePath}" : null;
    // }

    public function getImageUrlAttribute($value)
    {
        $imagePath = $this->attributes['image'];
        return $imagePath ? "https://admin.madinigroup.com/storage/{$imagePath}" : null;
    }

    // Ensure the image_url is appended to the model's array and JSON forms
    protected $appends = ['image_url'];

    public function getCoverImageAttribute()
    {
        $imagePath = $this->attributes['image'];

        // Generate the full URL using the asset function
        return $imagePath ? asset("storage/properties/{$imagePath}") : null;
    }
}
