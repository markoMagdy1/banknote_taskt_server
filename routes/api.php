<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


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

Route::get('/products',[ProductController::class,'get']);
Route::post('/add_product',[ProductController::class,'add_product']);
Route::get('/products/{id}',[ProductController::class,'get_product']);
Route::put('/products/{id}',[ProductController::class,'update_product']);
Route::delete('/products/{id}',[ProductController::class,'delete']);
