<?php

namespace App\Http\Controllers;

use App\Models\Genders;
use App\Models\PetOwner;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class PetOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $petOwner = PetOwner::latest()->paginate(5);
        $gender = Genders::all();
        return view('owner.index', compact('petOwner', 'gender'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|regex:/^[a-zA-Z\s]+$/u|max:255',
                'last_name' => 'required|regex:/^[a-zA-Z\s]+$/u|max:255',
                'gender_id' => ['required'],
                'address' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/',
                'phone_number' => 'nullable|numeric|digits_between:9,12',
                'emergency_phone_number' => 'nullable|numeric|digits_between:9,12',
                'email' => 'required|email'
            ]);

            $petOwner = PetOwner::create($validatedData);
            $gender = Genders::find($petOwner->gender_id);
            $transformedPetowner = [
                'id' => $petOwner->id,
                'first_name' => $petOwner->first_name,
                'last_name' => $petOwner->last_name,
                'gender' => [
                    'gender_name' => $gender->gender_name,
                ],
                'email' => $petOwner->email,
                'address' => $petOwner->address,
                'phone_number' => $petOwner->phone_number,
                'emergency_phone_number' => $petOwner->emergency_phone_number,
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully added',
                'data' => $transformedPetowner
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
    public function show(PetOwner $petOwner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetOwner $petOwner): View
    {
        $gender = Genders::all();
        return view('owner.edit', compact('petOwner', 'gender'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PetOwner $petOwner): Response
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|regex:/^[a-zA-Z\s]+$/u|max:255',
                'last_name' => 'required|regex:/^[a-zA-Z\s]+$/u|max:255',
                'gender_id' => ['required'],
                'address' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/',
                'phone_number' => 'nullable|numeric|digits_between:9,12',
                'emergency_phone_number' => 'nullable|numeric|digits_between:9,12',
                'email' => 'required|email'
            ]);

            $petOwner->update($validatedData);
            $gender = Genders::find($petOwner->gender_id);
            $transformedPetowner = [
                'id' => $petOwner->id,
                'first_name' => $petOwner->first_name,
                'last_name' => $petOwner->last_name,
                'gender' => [
                    'gender_name' => $gender->gender_name,
                ],
                'email' => $petOwner->email,
                'address' => $petOwner->address,
                'phone_number' => $petOwner->phone_number,
                'emergency_phone_number' => $petOwner->emergency_phone_number,
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully added',
                'data' => $transformedPetowner
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
    public function destroy(PetOwner $petOwner)
    {
        try {
            $petOwner->delete();

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
