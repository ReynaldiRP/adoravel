<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetRegistration extends Model
{
    use HasFactory;
    protected $table = 'pet_registrations';
    protected $fillable = ['owner_id', 'pet_name', 'pet_type_id'];

    public function petType()
    {
        return $this->belongsTo(PetType::class);
    }
    public function petOwner()
    {
        return $this->belongsTo(PetOwner::class, 'owner_id', 'id');
    }
    public function transaction()
    {
        return $this->hasOne(Transactions::class, 'id');
    }
}
