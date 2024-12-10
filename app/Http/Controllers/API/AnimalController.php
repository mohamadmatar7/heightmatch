<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;
use Illuminate\Support\Facades\Storage;

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

    // ceate a new animal
    public function create()
    {
        return view('animals.create-animal');
    }

    // store the animal
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'required|string',
            'jump_height' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        // Create and store the new animal
        $animal = new Animal();
        $animal->name = $request->name;
        $animal->type = $request->type;
        $animal->description = $request->description;
        $animal->jump_height = $request->jump_height;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images/animals');
            $animal->image = Storage::url($imagePath);
        }
        
        $animal->save();
        
        //return response()->json($animal);
        return redirect()->route('animals')->with('success', 'Animal created successfully.');
    }

    // show the animals
    public function index()
    {
        $animals = Animal::all();
        return view('animals.index', ['animals' => $animals]);
    }

    // delete an animal
    public function destroy($id)
    {
        $animal = Animal::find($id);
        $animal->delete();
        return redirect()->route('animals')->with('success', 'Animal deleted successfully.');
    }
    
}