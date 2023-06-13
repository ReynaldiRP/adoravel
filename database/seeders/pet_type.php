<?php

namespace Database\Seeders;

use App\Models\PetType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class pet_type extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PetType::create([
            'type' => 'anjing'
        ]);
        PetType::create([
            'type' => 'kucing'
        ]);
    }
}
