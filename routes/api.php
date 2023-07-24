<?php

use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\GetDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/submit-form', [FormController::class, "submitForm"]);
Route::post('/check-discount-code', [DiscountCodeController::class, "checkDiscountCode"]);
Route::get('/get-data', [GetDataController::class, "getData"]);
