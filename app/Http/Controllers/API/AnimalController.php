<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;

class AnimalController extends Controller
{
    // api routes
    public function animalByHeight(Request $request)
    {
        $height = $request->input('height');
        // get the animal closest to the given height
        $animal = Animal::orderByRaw('ABS(jump_height - ?)', [$height])->first();
        return response()->json($animal);
    }
}