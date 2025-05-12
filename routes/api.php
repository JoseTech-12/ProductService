<?php

use App\Http\Controllers\ProductController;
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



Route::get('/product', [ProductController::class, 'index'])->name('producto');
Route::post('/createProduct', [ProductController::class, 'store'])->name('createProducto');
Route::get('/showProduct/{id}', [ProductController::class, 'show'])->name('showProduct');
Route::put('/updateProduct/{id}', [ProductController::class, 'update'])->name('updateProducto');
Route::put('/updateProductStock/{id}', [ProductController::class, 'updateStock'])->name('updateProductoStock');
Route::put('/restore-stock/{id}', [ProductController::class, 'restoreStock']);
Route::delete('/deleteProduct/{id}', [ProductController::class, 'destroy'])->name('deleteProducto');
