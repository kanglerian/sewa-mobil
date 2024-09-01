<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'type',
        'plate_number',
        'rates',
        'available',
    ];

    public function rentalcars(){
        return $this->hasMany(RentalCars::class, 'car_id');
    }

    public function returncars(){
        return $this->hasMany(ReturnCars::class, 'car_id');
    }
}
