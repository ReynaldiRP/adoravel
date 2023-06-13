<?php

namespace Database\Seeders;

use App\Models\Genders as ModelsGenders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class genders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsGenders::create([
            'gender_name' => 'Laki-laki'
        ]);
        ModelsGenders::create([
            'gender_name' => 'Perempuan'
        ]);
    }
}
