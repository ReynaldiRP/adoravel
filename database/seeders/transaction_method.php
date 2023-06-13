<?php

namespace Database\Seeders;

use App\Models\TransactionMethods;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class transaction_method extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'transaction_type' => 'Cash',
            ],
            [
                'transaction_type' => 'Credit Card',
            ],
            [
                'transaction_type' => 'Debit Card',
            ],
        ];
        foreach ($paymentMethods as $paymentMethod) {
            TransactionMethods::create($paymentMethod);
        }
    }
}
