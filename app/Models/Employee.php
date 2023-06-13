<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $fillable = [
        'first_name', 'last_name', 'gender_id', 'position_id', 'email',
        'address', 'phone_number', 'salary', 'join_date'
    ];
    public function gender()
    {
        return $this->belongsTo(Genders::class);
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function transaction()
    {
        return $this->hasOne(Transactions::class, 'id', 'employee_id');
    }
}
