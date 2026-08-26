<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    // Tambahkan properti $fillable ini
    protected $fillable = [
        'user_id',
        'car_id',
    ];

    /**
     * Relasi ke Model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Model Car
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}