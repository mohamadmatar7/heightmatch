<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;


class PlayerController extends Controller
{
    public function index()
    {
        return Player::all();
    }

    public function highestJump()
    {
        return Player::orderBy('jump', 'desc')->first();
    }

    public function showHighestJump()
    {

        $player = $this->highestJump();

        return view('player-input', compact('player'));
    }

    // public function store(Request $request)
    // {
    //     $record = new Player();
    //     $record->name = $request->name;
    //     $record->jump = $request->jump;
    //     $record->save();
    // }
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|numeric',
            'jump' => 'nullable|numeric'
        ]);

        // Create and store the new player
        $player = new Player();
        $player->name = $request->name;
        $player->age = $request->age;
        $player->jump = $request->jump ?? 0; // Default jump to 0 if not provided
        $player->save();

        // Return JSON response with the saved player data
        return response()->json([
            'success' => true,
            'player' => $player
        ]);
    }
}