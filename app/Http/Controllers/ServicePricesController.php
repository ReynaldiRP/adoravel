<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use App\Models\ServicePrices;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class ServicePricesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $servicePet = ServicePrices::latest()->paginate(5);
        $serviceType = ServiceType::all();
        return view('service_pet.index', compact('servicePet', 'serviceType'));
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
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'service_id' => ['required'],
                'price' => 'required|numeric|min:0',

            ]);

            $servicePet = ServicePrices::create($validatedData);
            $serviceType = ServiceType::find($servicePet->service_id);
            $transformedServicePet = [
                'id' => $servicePet->id,
                'service_type' => [
                    'service_name' => $serviceType->service_name,
                    'description' => $serviceType->description,
                ],
                'price' => $servicePet->price
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully added',
                'data' => $transformedServicePet
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
    public function show(ServicePrices $servicePrices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServicePrices $servicePet)
    {
        $serviceType = ServiceType::all();
        return view('service_pet.edit', compact('servicePet', 'serviceType'));
    }
    
    public function get_detail_service($servicePetId)
    {
        $serviceType = ServiceType::find($servicePetId);

        if (!$serviceType) {
            return response()->json([
                'error' => 'Service not found'
            ], 404);
        }

        return response()->json([
            'data' => $serviceType->description,
        ]);
    }







    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServicePrices $servicePet)
    {
        try {
            $validatedData = $request->validate([
                'service_id' => ['required'],
                'price' => 'required|numeric|min:0',

            ]);

            $servicePet->update($validatedData);
            $serviceType = ServiceType::find($servicePet->service_id);
            $transformedServicePet = [
                'id' => $servicePet->id,
                'service_type' => [
                    'service_name' => $serviceType->service_name,
                    'description' => $serviceType->description,
                ],
                'price' => $servicePet->price
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully added',
                'data' => $transformedServicePet
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
    public function destroy(ServicePrices $servicePet)
    {
        try {
            $servicePet->delete();

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
