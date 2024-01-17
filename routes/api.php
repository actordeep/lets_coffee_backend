<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



// Public Routes
Route::post('/register',[UserController::class, 'register']);
Route::post('/login',[UserController::class, 'login']);


// Protectd Routes
Route::middleware(['auth:sanctum'])->group(function () {
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/loggeduser', [UserController::class, 'logged_user']);
Route::post('/changepassword', [UserController::class, 'change_password']);
});

