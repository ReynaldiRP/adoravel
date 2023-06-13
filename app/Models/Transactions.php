<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'pet_owner_id',
        'employee_id',
        'service_id',
        'pet_registration_id',
        'transaction_method_id',
        'transaction_date',

    ];

    public function transactionMethod()
    {
        return $this->belongsTo(
            TransactionMethods::class,
            'transaction_method_id'
        );
    }
    public function petRegistration()
    {
        return $this->belongsTo(
            PetRegistration::class,
            'pet_registration_id'
        );
    }
    public function petOwner()
    {
        return $this->belongsTo(
            PetOwner::class,
            'pet_owner_id'
        );
    }
    public function employee()
    {
        return $this->belongsTo(
            Employee::class,
            'employee_id'
        );
    }
    public function servicePrice()
    {
        return $this->belongsTo(
            ServicePrices::class,
            'service_id'
        );
    }
    public function detailTransaction()
    {
        return $this->hasOne(
            DetailTransactions::class,
            'id'
        );
    }
}
