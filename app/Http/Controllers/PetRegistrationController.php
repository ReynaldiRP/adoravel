<?php

namespace App\Http\Controllers;

use App\Models\PetType;
use App\Models\PetOwner;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\PetRegistration;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class PetRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $petOwner = PetOwner::all();
        $petType = PetType::all();
        $petRegistration = PetRegistration::latest()->paginate(5);
        return view('pet_registration.index', compact('petOwner', 'petType', 'petRegistration'));
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
                'owner_id' => ['required'],
                'pet_name' => 'required|regex:/^[a-zA-Z\s]+$/u|max:255',
                'pet_type_id' => ['required'],
            ]);

            $petRegistration = PetRegistration::create($validatedData);
            $petOwner = PetOwner::find($petRegistration->owner_id);
            $petType = PetType::find($petRegistration->pet_type_id);
            $transformedPetRegistration = [
                'id' => $petRegistration->id,
                'owner_name' => [
                    'first_name' => $petOwner->first_name,
                    'last_name' => $petOwner->last_name,
                ],
                'pet_name' => $petRegistration->pet_name,
                'pet_type' => [
                    'type' => $petType->type,
                ],
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully added',
                'data' => $transformedPetRegistration
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
    public function show(PetRegistration $petRegistration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetRegistration $petRegistration)
    {
        $petOwner = PetOwner::all();
        $petType = PetType::all();
        return view('pet_registration.edit', compact('petOwner', 'petType', 'petRegistration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PetRegistration $petRegistration)
    {
        try {
            $validatedData = $request->validate([
                'owner_id' => ['required'],
                'pet_name' => 'required|regex:/^[a-zA-Z\s]+$/u|max:255',
                'pet_type_id' => ['required'],
            ]);

            $petRegistration->update($validatedData);
            $petOwner = PetOwner::find($petRegistration->owner_id);
            $petType = PetType::find($petRegistration->pet_type_id);
            $transformedPetRegistration = [
                'id' => $petRegistration->id,
                'owner_name' => [
                    'first_name' => $petOwner->first_name,
                    'last_name' => $petOwner->last_name,
                ],
                'pet_name' => $petRegistration->pet_name,
                'pet_type' => [
                    'type' => $petType->type,
                ],
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully added',
                'data' => $transformedPetRegistration
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
    public function destroy(PetRegistration $petRegistration)
    {
        try {
            $petRegistration->delete();
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
