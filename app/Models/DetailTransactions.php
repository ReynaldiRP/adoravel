<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransactions extends Model
{
    use HasFactory;
    protected $table = 'detail_transactions';
    protected $fillable = [
        'transaction_id',
        'pet_registration_id',
        'service_id',
        'pet_food_id',
        'quantity',
        'total_amount'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transactions::class);
    }
    public function petFood()
    {
        return $this->belongsTo(PetFoodPrices::class, 'pet_food_id');
    }
    public function servicePet()
    {
        return $this->belongsTo(ServicePrices::class, 'service_id');
    }
    public function petRegistration()
    {
        return $this->belongsTo(PetRegistration::class, 'pet_registration_id');
    }
}
