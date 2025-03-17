<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\CandidatureController;

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


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    

    Route::post('/cvs', [ProfileController::class, 'uploadCV']);
    Route::get('/cvs', [ProfileController::class, 'getCVs']);
    Route::delete('/cvs/{id}', [ProfileController::class, 'deleteCV']);
    
    
    Route::get('/candidatures', [CandidatureController::class, 'index']);
    Route::post('/candidatures', [CandidatureController::class, 'store']);
    Route::get('/candidatures/{id}', [CandidatureController::class, 'show']);
    Route::post('/candidatures/bulk', [CandidatureController::class, 'storeBulk']);
    Route::put('/candidatures/{id}/cancel', [CandidatureController::class, 'cancel']); 
    
    
    Route::middleware('admin')->group(function () {

        Route::post('/offres', [OffreController::class, 'store']);
        Route::put('/offres/{id}', [OffreController::class, 'update']);
        Route::delete('/offres/{id}', [OffreController::class, 'destroy']);
        
        
        Route::put('/candidatures/{id}/status', [CandidatureController::class, 'updateStatus']);
    });
});

Route::get('/offres', [OffreController::class, 'index']);
Route::get('/offres/{id}', [OffreController::class, 'show']);  
