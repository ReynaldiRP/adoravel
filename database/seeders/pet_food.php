<?php

namespace Database\Seeders;

use App\Models\PetFoods;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class pet_food extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catFoods = [
            [
                'food_name' => 'Tuna Delight',
                'brand' => 'Meow Mix',
                'description' => 'A delicious blend of tuna and other seafood flavors that cats adore.',
            ],
            [
                'food_name' => 'Chicken Feast',
                'brand' => 'Whiskas',
                'description' => 'Tender chicken morsels in a savory gravy, providing complete and balanced nutrition for cats.',
            ],
            // Add more cat food entries as needed
        ];

        $dogFoods = [
            [
                'food_name' => 'Beefy Bites',
                'brand' => 'Pedigree',
                'description' => 'Hearty beef-flavored kibble packed with essential nutrients for dogs of all sizes.',
            ],
            [
                'food_name' => 'Chicken and Rice Formula',
                'brand' => 'Blue Buffalo',
                'description' => 'A nutritious blend of chicken and brown rice, promoting healthy digestion and immune system.',
            ],
            // Add more dog food entries as needed
        ];

        foreach ($catFoods as $catFood) {
            PetFoods::create([
                'food_name' => $catFood['food_name'],
                'brand' => $catFood['brand'],
                'description' => $catFood['description']
            ]);
        }

        foreach ($dogFoods as $dogFood) {
            PetFoods::create([
                'food_name' => $dogFood['food_name'],
                'brand' => $dogFood['brand'],
                'description' => $dogFood['description']
            ]);
        }
    }
}
