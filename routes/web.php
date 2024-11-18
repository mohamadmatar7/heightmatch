<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AnimalController;
use App\Http\Controllers\API\PlayerController;

// api routes
// GROUP with api prefix
Route::prefix('api')->group(function () {
    Route::get('/beestje', [AnimalController::class, 'animalByHeight'])->name('animalByHeight');

    Route::get('/spelers', [PlayerController::class, 'index'])->name('players');
    Route::post('/speler', [PlayerController::class, 'store'])->name('storePlayer');
});

Route::get('/original', function () {
    return view('interfaceOriginal');
});

Route::get('/', [PlayerController::class, 'showHighestJump']);