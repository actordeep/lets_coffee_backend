<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SaleController;

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




Route::post('/sales', [SaleController::class, 'store']);

// Retrieve all sales
Route::get('/sales', [SaleController::class, 'index']);

// Retrieve month sales
Route::get('/sales/month', [SaleController::class, 'monthSales']);

// Retrieve week sales
Route::get('/sales/week', [SaleController::class, 'weekSales']);

// Retrieve day sales
Route::get('/sales/day', [SaleController::class, 'daySales']);

Route::post('order',[SaleController::class, 'order']);

















Route::prefix('reviews')->group(function () {
    // Create a new review
    Route::post('/', [ReviewController::class, 'createReview']);

    // Get all reviews for an item
    Route::get('/item/add-review', [ReviewController::class, 'addReview']);

    // Get average rating for an item
    Route::get('/average-rating/{itemType}/{itemId}', [ReviewController::class, 'getAverageRatingForItem']);
});




