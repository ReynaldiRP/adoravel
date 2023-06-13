<?php

namespace Database\Seeders;

use App\Models\Position as ModelsPosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class position extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsPosition::create([
            'job_name' => 'admin'
        ]);
        ModelsPosition::create([
            'job_name' => 'marketing'
        ]);
        ModelsPosition::create([
            'job_name' => 'ceo'
        ]);
    }
}
