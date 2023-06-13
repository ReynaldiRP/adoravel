<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetFoodPrices extends Model
{
    use HasFactory;
    protected $table = 'pet_food_prices';
    protected $fillable = ['pet_food_id', 'price'];

    public function petFoodType()
    {
        return $this->belongsTo(PetFoods::class, 'pet_food_id', 'id');
    }
}
