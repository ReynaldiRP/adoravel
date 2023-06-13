<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePrices extends Model
{
    use HasFactory;
    protected $table = 'service_prices';
    protected $fillable = ['service_id', 'price'];

    public function serviceType()
    {
        return $this->belongsTo(serviceType::class, 'service_id');
    }
    public function transaction()
    {
        return $this->hasOne(Transactions::class, 'id');
    }
    public function detailTransaction()
    {
        return $this->hasOne(DetailTransactions::class, 'id');
    }
}
