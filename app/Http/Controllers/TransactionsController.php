<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PetOwner;
use App\Models\PetRegistration;
use App\Models\ServiceType;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\ServicePrices;
use App\Models\TransactionMethods;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaction = Transactions::all();
        $petOwner = PetOwner::all();
        $employee = Employee::all();
        $servicePet = ServicePrices::all();
        $petRegistration = PetRegistration::all();
        $transaction_method = TransactionMethods::all();

        return view('transaction.index', compact('transaction', 'petOwner', 'employee', 'petRegistration', 'servicePet', 'transaction_method'));
    }

    public function get_detail_service_price($servicePetId)
    {
        $servicePrice = ServicePrices::where('id', $servicePetId)->first();

        if (!$servicePrice) {
            return response()->json([
                'error' => 'Service not found'
            ], 404);
        }

        return response()->json([
            'data' => $servicePrice->price,
        ]);
    }

    public function print(Transactions $transaction)
    {
        return view('transaction.print', compact('transaction'));
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
                'pet_owner_id' => ['required'],
                'service_id' => ['required'],
                'employee_id' => ['required'],
                'pet_registration_id' => ['required'],
                'transaction_method_id' => ['required'],
                'transaction_date' => 'required|date',

            ]);

            $transaction = Transactions::create($validatedData);
            $petOwner = PetOwner::find($transaction->pet_owner_id);
            $employee = Employee::find($transaction->employee_id);
            $servicePet = ServicePrices::with('serviceType')->find($transaction->service_id);
            $petRegistration = PetRegistration::find($transaction->pet_registration_id);
            $transaction_method = TransactionMethods::find($transaction->transaction_method_id);


            $transformedTransaction = [
                'id' => $transaction->id,
                'owner_name' => [
                    'first_name' => $petOwner->first_name,
                    'last_name' => $petOwner->last_name
                ],
                'pet' => [
                    'pet_name' => $petRegistration->pet_name
                ],
                'employee_name' => [
                    'first_name' => $employee->first_name,
                    'last_name' => $employee->last_name
                ],
                'service_type' => [
                    'service_name' => $servicePet->serviceType->service_name,
                    'price' => $servicePet->price
                ],
                'transaction_method' => [
                    'type' => $transaction_method->transaction_type
                ],
                'transaction_date' => $transaction->transaction_date
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully added',
                'data' => $transformedTransaction
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
    public function show(Transactions $transactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transactions $transaction)
    {
        $petOwner = PetOwner::all();
        $employee = Employee::all();
        $servicePet = ServicePrices::all();
        $petRegistration = PetRegistration::all();
        $transaction_method = TransactionMethods::all();

        return view('transaction.edit', compact('transaction', 'petOwner', 'employee', 'petRegistration', 'servicePet', 'transaction_method'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transactions $transaction)
    {
        try {
            $validatedData = $request->validate([
                'pet_owner_id' => ['required'],
                'pet_registration_id' => ['required'],
                'service_id' => ['required'],
                'employee_id' => ['required'],
                'transaction_method_id' => ['required'],
                'transaction_date' => 'required|date'

            ]);

            $transaction->update($validatedData);
            $petOwner = PetOwner::find($transaction->pet_owner_id);
            $petRegistration = PetRegistration::find($transaction->pet_registration_id);
            $employee = Employee::find($transaction->employee_id);
            $servicePet = ServicePrices::with('serviceType')->find($transaction->service_id);
            $transaction_method = TransactionMethods::find($transaction->transaction_method_id);


            $transformedTransaction = [
                'id' => $transaction->id,
                'owner_name' => [
                    'first_name' => $petOwner->first_name,
                    'last_name' => $petOwner->last_name,
                ],
                'pet' => [
                    'pet_name' => $petRegistration->pet_name
                ],
                'employee_name' => [
                    'first_name' => $employee->first_name,
                    'last_name' => $employee->last_name,
                ],
                'service_type' => [
                    'service_name' => $servicePet->serviceType->service_name,
                    'price' => $servicePet->price,
                ],
                'transaction_method' => [
                    'type' => $transaction_method->transaction_type
                ],
                'transaction_date' => $transaction->transaction_date,
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully added',
                'data' => $transformedTransaction
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
    public function destroy(Transactions $transaction)
    {
        try {
            $transaction->delete();

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
