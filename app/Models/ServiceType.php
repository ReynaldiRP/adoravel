<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;
    protected $table = 'service_types';

    public function servicePrice()
    {
        return $this->hasOne(ServicePrices::class, 'id', 'service_id');
    }
}
