<?php

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecommendationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\PlatController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    //  Profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    Route::apiResource('categories', CategorieController::class)
        ->parameters(['categories' => 'categorie']);
    Route::apiResource('plats', PlatController::class);

    Route::post('/categories/{categorie}/plats',[PlatController::class,'storeByCategory']);

    // Ingredients
    Route::get('/ingredients', [IngredientController::class, 'index']);
    Route::post('/ingredients', [IngredientController::class, 'store']);
    Route::get('/ingredients/{ingredient}', [IngredientController::class, 'show']);
    Route::put('/ingredients/{ingredient}', [IngredientController::class, 'update']);
    Route::delete('/ingredients/{ingredient}', [IngredientController::class, 'destroy']);

    // Recommendations
  

});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/recommendations/analyze/{plate_id}', [RecommendationController::class, 'analyze']);

    Route::get('/recommendations', [RecommendationController::class, 'index']);

    Route::get('/recommendations/{plate_id}', [RecommendationController::class, 'show']);
});
