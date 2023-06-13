<?php

use App\Http\Controllers\DetailTransactionsController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PetFoodPricesController;
use App\Http\Controllers\PetOwnerController;
use App\Http\Controllers\PetRegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicePricesController;
use App\Http\Controllers\TransactionsController;
use App\Models\DetailTransactions;
use App\Models\Employee;
use App\Models\PetFoodPrices;
use App\Models\PetRegistration;
use App\Models\ServicePrices;
use App\Models\Transactions;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('template.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('petOwner', PetOwnerController::class);
Route::resource('employee', EmployeeController::class);
Route::resource('petRegistration', PetRegistrationController::class);
Route::resource('servicePet', ServicePricesController::class);
Route::resource('petFood', PetFoodPricesController::class);
Route::resource('transaction', TransactionsController::class);
Route::resource('detail_transaction', DetailTransactionsController::class);
Route::get('get_detail_service/{servicePet}', [ServicePricesController::class, 'get_detail_service']);
Route::get('get_detail_service_price/{servicePet}', [TransactionsController::class, 'get_detail_service_price']);
Route::get('get_detail_transaction/{detail_transaction}', [DetailTransactionsController::class, 'get_detail_transaction']);
Route::get('print_transaction/{transaction}', [TransactionsController::class, 'print']);
Route::get('get_detail_food/{petFood}', [PetFoodPricesController::class, 'get_detail_food']);
Route::get('get_food_price/{petFood}', [DetailTransactionsController::class, 'get_food_price']);
require __DIR__ . '/auth.php';
