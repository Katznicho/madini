<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cooperative extends Model
{
    use HasFactory;

    protected $casts = [
        'description' => 'array',
    ];

    protected $fillable = [
        'name',
        'description',
        'logo',
        'status',
        'phone_number',
        'email',
        'website',
        'account_number',
        'address',
    ];

    //a cooperative has many miners
    public function miners()
    {
        return $this->hasMany(Miner::class);
    }
}
