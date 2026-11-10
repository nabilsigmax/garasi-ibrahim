<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'body_type_id',
        'year',
        'price',
        'color',
        'transmission',
        'fuel',
        'engine_capacity',
        'passenger_capacity',
        'mileage',
        'condition',
        'description',
        'image',
        'gallery',
    ];

    protected $casts = [
        'gallery' => 'array',
    ];

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function bodyType()
    {
        return $this->belongsTo(BodyType::class);
    }

    public function chatRooms()
    {
        return $this->hasMany(ChatRoom::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
