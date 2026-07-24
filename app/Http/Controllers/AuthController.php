<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\GameSession;
use App\Http\Resources\PlayerResource;
use App\Http\Requests\AuthRequest;

class AuthController extends Controller
{
    public function identify(AuthRequest $request)
    {
        $name = $request->input('name');
        $player = Player::with('gameSession')->where('name', $name)->first();
        if($player == null)
            {
                $player = Player::create(['name' => $name]);              
            }
            else 
            {
                $player->tokens()->delete();
            }
        $token = $player->createToken('auth-token')->plainTextToken;
        return response()->json(['status' => 'success', 
        'message' => 'Player completed identification', 
        'data' => new PlayerResource($player), 
        'token' => $token], 200);
    }
}
