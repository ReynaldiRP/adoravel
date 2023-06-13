<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionMethods extends Model
{
    use HasFactory;
    protected $table = 'transaction_methods';


    public function transaction()
    {
        return $this->hasOne(
            Transactions::class,
            'id',
            'transaction_method_id'
        );
    }
}
