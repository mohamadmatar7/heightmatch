<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AnimalController extends Controller
{
    // api routes
    // public function animalByHeight(Request $request)
    // {
    //     $height = $request->input('height');
    //     // get the animal closest to the given height
    //     $animal = Animal::orderByRaw('ABS(jump_height - ?)', [$height])->first();
    //     return response()->json($animal);
    // }

    public function animalByHeight(Request $request)
    {
        // Get the current locale (e.g., 'en', 'fr', 'es')
        $language = LaravelLocalization::getCurrentLocale(); 
    
        // Other code for fetching the animal data
        $height = $request->input('height');
        $animal = Animal::orderByRaw('ABS(jump_height - ?)', [$height])->first();
        
        // Translate animal data based on slug
        $translations = __('animals.' . $animal->slug);
        
        // Prepare the translated data or fallback to original if no translation exists
        $translatedAnimal = [
            'name' => $translations['name'] ?? $animal->name,
            'type' => $translations['type'] ?? $animal->type,
            'description' => $translations['description'] ?? $animal->description,
            'jump_height' => $animal->jump_height,
            'image' => $animal->image,
        ];
    
        // Return the translated animal data as a JSON response
        return response()->json($translatedAnimal);
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:6000',
        ]);

        $slug = strtolower(str_replace(' ', '-', $request->name));
        
        // Create and store the new animal
        $animal = new Animal();
        $animal->slug = $slug;
        $animal->name = $request->name;
        $animal->type = $request->type;
        $animal->description = $request->description;
        $animal->jump_height = $request->jump_height;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/animals', 'public');
            $animal->image = Storage::url($imagePath);
        }
        
        $animal->save();
        return redirect()->route('animals')->with('success', 'Animal created successfully.');
    }

    // show the animals
    // public function index()
    // {
        
    //     $animals = Animal::all();
    //     return view('animals.index', ['animals' => $animals]);
    // }
    public function index()
    {
        $language = app()->getLocale(); // Get the current locale, e.g., 'en', 'fr'
    
        $animals = Animal::all(); // Get all animals from the database
    
        $translatedAnimals = $animals->map(function ($animal) use ($language) {
            // Get the translation based on the current locale
            $translations = __('animals.' . $animal->slug, [], $language);
    
            return [
                'name' => $translations['name'] ?? $animal->name,
                'type' => $translations['type'] ?? $animal->type,
                'description' => $translations['description'] ?? $animal->description,
                'jump_height' => $animal->jump_height,
                'image' => $animal->image,
                'id' => $animal->id,
            ];
        });
    
        return view('animals.index', ['animals' => $translatedAnimals]);
    }
    


    // delete an animal
    public function destroy($id)
    {
        $animal = Animal::find($id);
        $animal->delete();
        return redirect()->route('animals')->with('success', 'Animal deleted successfully.');
    }
    
}