<?php

namespace App\Http\Controllers;

use App\Models\PetFoods;
use Illuminate\View\View;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\PetFoodPrices;
use App\Models\ServicePrices;
use App\Models\PetRegistration;
use App\Models\DetailTransactions;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class DetailTransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $detail_transaction = DetailTransactions::all();
        $petFood = PetFoodPrices::all();
        $petService = ServicePrices::all();
        $transaction = Transactions::all();
        $petRegistration = PetRegistration::all();

        return view('detail_transaction.index', compact('detail_transaction', 'petFood', 'petService', 'transaction', 'petRegistration'));
    }

    public function get_food_price($petFoodId)
    {
        $petFood = PetFoodPrices::where('id', $petFoodId)->first();

        if (!$petFood) {
            return response()->json([
                'error' => 'Price not found'
            ], 404);
        }

        return response()->json([
            'data' => $petFood->price
        ]);
    }


    public function get_detail_transaction($transactionId)
    {
        $transaction = Transactions::with('servicePrice.serviceType', 'petRegistration')->find($transactionId);

        if (!$transaction) {
            return response()->json([
                'error' => 'Transaction not found'
            ], 404);
        }

        $data = [
            'service_id' => $transaction->servicePrice->id,
            'service_name' => $transaction->servicePrice->serviceType->service_name,
            'service_price' => $transaction->servicePrice->price,
            'pet_registration_id' => $transaction->petRegistration->id,
            'pet_name' => $transaction->petRegistration->pet_name,
        ];

        return response()->json([
            'data' => $data,
        ]);
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
        // dd($request->all());
        try {
            $validatedData = $request->validate([
                'transaction_id' => 'required',
                'pet_registration_id' => 'required',
                'service_id' => 'required',
                'pet_food_id' => 'required',
                'quantity' => 'required|numeric|min:0',
                'total_amount' => 'required',

            ]);

            $detail_transaction = DetailTransactions::create($validatedData);
            $transaction = Transactions::find($detail_transaction->transaction_id);
            $petRegistration = PetRegistration::find($detail_transaction->pet_registration_id);
            $service_id = ServicePrices::find($detail_transaction->service_id);
            $pet_food_id = PetFoodPrices::find($detail_transaction->pet_food_id);


            $transformedTransaction = [
                'id' => $detail_transaction->id,
                'transaction' => [
                    'transaction_id' => formatTransactionId($transaction->id),
                    'transaction_method' => $transaction->transactionMethod->transaction_type,
                    'transaction_date' => $transaction->transaction_date,
                ],
                'pet_registration' => [
                    'pet_name' => $petRegistration->pet_name,
                    'pet_type' => $petRegistration->petType->type
                ],
                'service_type' => [
                    'service_name' => $service_id->serviceType->service_name,
                    'service_description' => $service_id->serviceType->description,
                    'service_price' => $service_id->price
                ],
                'pet_food' => [
                    'pet_food_name' => $pet_food_id->petFoodType->food_name,
                    'pet_food_brand' => $pet_food_id->petFoodType->brand,
                    'pet_food_description' => $pet_food_id->petFoodType->description,
                    'pet_food_price' => $pet_food_id->price

                ],
                'quantity' => $detail_transaction->quantity,
                'total_amount' => $detail_transaction->total_amount
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
    public function show(DetailTransactions $detailTransactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailTransactions $detailTransactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailTransactions $detailTransactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailTransactions $detail_transaction)
    {
        try {
            $detail_transaction->delete();

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
