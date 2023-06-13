<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class service_type extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceTypes = [
            [
                'service_name' => 'Grooming',
                'description' => 'Professional grooming services to keep your pets clean, healthy, and looking their best.',
            ],
            [
                'service_name' => 'Boarding',
                'description' => 'Safe and comfortable boarding facilities for pets when owners are away or unable to care for them.',
            ],
            [
                'service_name' => 'Training',
                'description' => 'Training programs to teach pets essential obedience commands and correct behavioral issues.',
            ],
            [
                'service_name' => 'Veterinary Care',
                'description' => 'Comprehensive medical care, including check-ups, vaccinations, and treatment for pets.',
            ],
            [
                'service_name' => 'Dog Walking',
                'description' => 'Regular exercise and walking services to keep dogs healthy, active, and stimulated.',
            ],
        ];

        foreach ($serviceTypes as $serviceType) {
            ServiceType::create([
                'service_name' => $serviceType['service_name'],
                'description' => $serviceType['description'],
            ]);
        }
    }
}
