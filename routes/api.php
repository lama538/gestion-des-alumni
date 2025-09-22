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



// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées par Sanctum
Route::middleware('auth:sanctum')->group(function() {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Users CRUD
    Route::apiResource('users', UserController::class);

    // Profils CRUD
    Route::apiResource('profils', ProfilController::class);

    // Offres CRUD
    Route::apiResource('offres', OffreController::class);

    // Messages CRUD
    Route::apiResource('messages', MessageController::class);

    // Evenements CRUD
    Route::apiResource('evenements', EvenementController::class);

    // Groupes CRUD
    Route::apiResource('groupes', GroupeController::class);

    // Articles CRUD
    Route::apiResource('articles', ArticleController::class);

   // récupérer le profil de l’utilisateur connecté
    Route::get('/profile', [UserController::class, 'profile']);

   // mettre à jour le profil de l’utilisateur connecté
    Route::put('/profile', [UserController::class, 'updateProfile']);

    Route::post('/password/update', [UserController::class, 'updatePassword']);
  



});
