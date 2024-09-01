<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalCars extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'user_id',
        'rates',
        'start',
        'end',
        'boolean',
    ];

    public function cars()
    {
        return $this->belongsTo(Car::class, 'car_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
