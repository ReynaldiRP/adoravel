<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genders extends Model
{
    use HasFactory;
    protected $table = 'genders';

    public function pet_owner()
    {
        return $this->hasOne(PetOwner::class);
    }
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}
