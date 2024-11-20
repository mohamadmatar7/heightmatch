<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\API\AnimalController;
use App\Http\Controllers\API\PlayerController;

// Web Routes - Add language prefix group for localization
Route::group([
    'prefix' => LaravelLocalization::setLocale(), // Set the language dynamically based on URL
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'] // Handle language-specific redirection and view paths
], function() {
    // Route to display the welcome page (localized)
    Route::get('/', function () {
        return view('welcome');
    });

    // Route to display the original interface page (localized)
    Route::get('/result', function () {
        return view('jump-result');
    });

    // Route to show player input page (localized)
    Route::get('/player-input', [PlayerController::class, 'showHighestJump'])->name('playerInput');
    

    Route::prefix('api')->group(function () {
        Route::get('/beestje', [AnimalController::class, 'animalByHeight'])->name('animalByHeight');
        Route::post('/update-player-jump', [PlayerController::class, 'updateJump']);
        Route::get('/spelers', [PlayerController::class, 'index'])->name('players');
        Route::post('/speler', [PlayerController::class, 'store'])->name('storePlayer');
    });
});



// API Routes - These are already prefixed with 'api'
// Route::prefix('api')->group(function () {
//     Route::get('/beestje', [AnimalController::class, 'animalByHeight'])->name('animalByHeight');
//     Route::get('/spelers', [PlayerController::class, 'index'])->name('players');
//     Route::post('/speler', [PlayerController::class, 'store'])->name('storePlayer');
// });