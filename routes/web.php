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
    // Show the animals
    Route::get('/animals', [AnimalController::class, 'index'])->name('animals');
    // create a new animal
    Route::get('/create-animal', [AnimalController::class, 'create'])->name('createAnimal');
    // store the animal
    Route::post('/store-animal', [AnimalController::class, 'store'])->name('storeAnimal');
    // delete the animal
    Route::delete('/delete-animal/{animal}', [AnimalController::class, 'destroy'])->name('deleteAnimal');

    Route::prefix('api')->group(function () {
        Route::get('/beestje', [AnimalController::class, 'animalByHeight'])->name('animalByHeight');

        Route::post('/update-player-jump', [PlayerController::class, 'updateJump']);
        Route::get('/spelers', [PlayerController::class, 'index'])->name('players');
        Route::post('/speler', [PlayerController::class, 'store'])->name('storePlayer');
        
        // get the highest 10 jumps
        Route::get('/scoreboard', [PlayerController::class, 'scoreboardAll'])->name('scoreboardAll');
        // get the highest 10 jumps of today
        Route::get('/scoreboard/today', [PlayerController::class, 'scoreboardToday'])->name('scoreboardToday');
        
    });
});



// API Routes - These are already prefixed with 'api'
// Route::prefix('api')->group(function () {
//     Route::get('/beestje', [AnimalController::class, 'animalByHeight'])->name('animalByHeight');
//     Route::get('/spelers', [PlayerController::class, 'index'])->name('players');
//     Route::post('/speler', [PlayerController::class, 'store'])->name('storePlayer');
// });