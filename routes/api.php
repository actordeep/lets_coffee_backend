<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileUpdateController;
use App\Http\Controllers\UserProfileController;


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

