<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileUpdateController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\orderStatusController;
use App\Http\Controllers\TransactionController;


// Public Routes
Route::post('/register',[UserController::class, 'register']);
Route::post('/login',[UserController::class, 'login']);
Route::post('/send-reset-password-email', [ResetPasswordController::class, 'send_reset_password_email']);

// Protectd Routes
Route::middleware(['auth:sanctum'])->group(function () {
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/loggeduser', [UserController::class, 'logged_user']);
Route::post('/changepassword', [UserController::class, 'change_password']);
});
Route::prefix('menu')->group(function () {
    Route::post('add', [MenuController::class, 'addItem']);
    Route::put('update/{id}', [MenuController::class, 'updateItem']);
    Route::delete('delete/{id}', [MenuController::class, 'deleteItem']);
});
Route::get('/update-profile',[UserProfileController::class,'UpdateProfile']);


Route::get('/inventory', [InventoryController::class, 'index']);
Route::post('/inventory1', [InventoryController::class, 'addItem']);
Route::post('/buyitem', [InventoryController::class, 'buyItem']);



Route::prefix('reviews')->group(function () {
    // Create a new review
    Route::post('/', [ReviewController::class, 'createReview']);

    // Get all reviews for an item
    Route::get('/item/add-review', [ReviewController::class, 'addReview']);

    // Get average rating for an item
    Route::get('/average-rating/{itemType}/{itemId}', [ReviewController::class, 'getAverageRatingForItem']);
});

Route::put('/orders/{orderId}/update-status', [orderStatusController::class, 'updateOrderStatus']);
Route::get('/orders/{orderId}/view-status', [orderStatusController::class, 'getStatusOrder']);


Route::get('/transactions', [TransactionController::class, 'index']);
Route::post('/transactions', [TransactionController::class, 'store']);