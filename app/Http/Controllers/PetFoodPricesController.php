<?php

namespace App\Http\Controllers;

use App\Models\DetailTransactions;
use App\Models\PetFoods;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\PetFoodPrices;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class PetFoodPricesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $petFood = PetFoodPrices::latest()->paginate(5);
        $petFoodType = PetFoods::all();
        return view('pet_food.index', compact('petFood', 'petFoodType'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        try {
            $validatedData = $request->validate([
                'pet_food_id' => ['required'],
                'price' => 'required|numeric|min:0',

            ]);

            $petFood = PetFoodPrices::create($validatedData);
            $petFoodType = PetFoods::find($petFood->pet_food_id);
            $transformedpetFood = [
                'id' => $petFood->id,
                'food_type' => [
                    'food_name' => $petFoodType->food_name,
                    'brand' => $petFoodType->brand,
                    'description' => $petFoodType->description,
                ],
                'price' => $petFood->price
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully added',
                'data' => $transformedpetFood
            ]);
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->all();
            return response()->json([
                'status' => 500,
                'message' => 'Failed to Add Data',
                'errors' => $error
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PetFoodPrices $petFoodPrices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetFoodPrices $petFood): View
    {
        $petFoodType = PetFoods::all();
        return view('pet_food.edit', compact('petFood', 'petFoodType'));
    }


    public function get_detail_food($petFoodId): Response
    {
        $petFoodType = PetFoods::find($petFoodId);

        if (!$petFoodType) {
            return response()->json([
                'error' => 'Service type not found'
            ], 404);
        }

        $data_food = [
            'brand' => $petFoodType->brand,
            'description' => $petFoodType->description
        ];

        return response()->json([
            'data' => $data_food,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PetFoodPrices $petFood): Response
    {
        try {
            $validatedData = $request->validate([
                'pet_food_id' => ['required'],
                'price' => 'required|numeric|min:0',

            ]);

            $petFood->update($validatedData);
            $petFoodType = PetFoods::find($petFood->pet_food_id);
            $transformedpetFood = [
                'id' => $petFood->id,
                'food_type' => [
                    'pet_food_id' => $petFoodType->food_name,
                    'brand' => $petFoodType->brand,
                    'description' => $petFoodType->description,
                ],
                'price' => $petFood->price
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully added',
                'data' => $transformedpetFood
            ]);
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->all();
            return response()->json([
                'status' => 500,
                'message' => 'Failed to Add Data',
                'errors' => $error
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetFoodPrices $petFood): Response
    {
        try {
            $petFood->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json([
                    'status' => 500,
                    'message' => 'Data gagal dihapus karena sedang digunakan.'
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to delete data'
                ]);
            }
        }
    }
}
