<?php

use App\Http\Controllers\transctionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReviewController;
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


Route::post('/register',[UserController::class, 'register']);
 Route::post('/login',[UserController::class, 'login']);

Route::post('/login', [UserController::class, 'login'])->middleware('authenticate');
Route::post('/logout',[UserController::class, 'logout'])->middleware('authenticate');

Route::post('/changepassword',[UserController::class, 'change_password']);
Route::post('/logeduser',[UserController::class, 'loged_user']);
Route::get('/search/{request}', [UserController::class, 'search']);


Route::get('/inventory', [InventoryController::class, 'index']);
Route::get('/inventory/{id}', [InventoryController::class, 'show']);
Route::post('/inventory', [InventoryController::class, 'store']);
Route::put('/inventory/{id}', [InventoryController::class, 'update']);
Route::delete('/inventory/{id}', [InventoryController::class, 'destroy']);


Route::post('/transactions', [transctionController::class, 'store']);

// Retrieve all sales
Route::get('/transactions', [transctionController::class, 'index']);

// Retrieve month sales
Route::get('/transactions/month', [transctionController::class, 'monthSales']);

// Retrieve week sales
Route::get('/transactions/week', [transctionController::class, 'weekSales']);

// Retrieve day sales
Route::get('/transactions/day', [transctionController::class, 'daySales']);

Route::post('order',[transctionController::class, 'order']);



Route::prefix('product')->group(function () {
    Route::post('add', [ProductController::class, 'addItem']);
    Route::put('update/{id}', [ProductController::class, 'updateItem']);
    Route::delete('delete/{id}', [ProductController::class, 'deleteItem']);

});

// Route::apiResource('reviews', [ReviewController::class] );

Route::prefix('reviews')->group( function () { 
    Route::post('/rating', [ReviewController::class,'review']);
    Route::post('comment', [ReviewController::class,'comment']);
    
}); 




