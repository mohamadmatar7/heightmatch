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

    // update player to get the highest jump from mqtt
    public function updateJump(Request $request)
    {
        $request->validate([
            'player_id' => 'required|exists:players,id',
            'jump' => 'required|numeric|min:0',
        ]);
    
        $player = Player::find($request->player_id);
    
        if (!$player) {
            return response()->json(['success' => false, 'message' => 'Player not found'], 404);
        }
    
        $player->jump = $request->jump;
        $player->save();
    
        return response()->json(['success' => true, 'player' => $player]);
    }

    // get the highest 10 jumps in the last 24 hours
    public function scoreboardToday()
    {
        $players = Player::where('created_at', '>=', now()->subDay())
            ->orderBy('jump', 'desc')
            ->limit(10)
            ->get();
        return view('scoreboard.today', compact('players'));
    }

    // get the highest 10 jumps of all time
    public function scoreboardAll()
    {
        $players = Player::orderBy('jump', 'desc')
            ->limit(10)
            ->get();
        return view('scoreboard.all-time', compact('players'));
    }

    
}