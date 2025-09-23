<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProfilController;
use App\Http\Controllers\Api\OffreController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\EvenementController;
use App\Http\Controllers\Api\GroupeController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Auth\ForgetPasswordController;



  Route::post('/forget-password', [ForgetPasswordController::class, 'sendResetLink']);
Route::post('/reset-password/{token}', [ForgetPasswordController::class, 'resetPassword'])
     ->name('password.reset');



// -----------------------------
// 🔑 Authentification publique
// -----------------------------
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// -----------------------------
// 🛡️ Routes protégées par Sanctum
// -----------------------------
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('profils', ProfilController::class);
    Route::apiResource('offres', OffreController::class);
    Route::apiResource('messages', MessageController::class);
    Route::apiResource('evenements', EvenementController::class);
    Route::apiResource('groupes', GroupeController::class);
    Route::apiResource('articles', ArticleController::class);
});
