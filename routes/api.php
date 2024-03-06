<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CustomerController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('customers', CustomerController::class)->except('update');
Route::apiResource('books', BookController::class)->only('index', 'show');

Route::post('books/{book}/customers/{customer}/borrow', [BookController::class, 'borrow']);
Route::post('books/{book}/drop', [BookController::class, 'drop']);
