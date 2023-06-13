<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetOwner extends Model
{
    use HasFactory;
    protected $table = 'pet_owners';
    protected $fillable = [
        'first_name', 'last_name', 'gender_id', 'email',
        'address', 'phone_number', 'emergency_phone_number',
    ];
    public function gender()
    {
        return $this->belongsTo(Genders::class);
    }
    public function petRegistration()
    {
        return $this->hasOne(PetRegistration::class, 'id', 'owner_id');
    }
    public function transaction()
    {
        return $this->hasOne(Transactions::class, 'id', 'owner_id');
    }
}
