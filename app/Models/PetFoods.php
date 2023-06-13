<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetFoods extends Model
{
    use HasFactory;
    protected $table = 'pet_foods';

    public function petFoodPrice()
    {
        return $this->hasOne(PetFoodPrices::class, 'id');
    }
    public function detailTransaction()
    {
        return $this->hasOne(DetailTransactions::class, 'id');
    }
}
