<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\GameSession;

class AuthController extends Controller
{
    public function identify(Request $request)
    {
        try {
            $name = $request->input('name');
            $player = Player::where('name', $name)->first();
            if($player == null)
                {
                    $player = Player::create(['name' => $name]);
                    $session = null;
                    return response()->json(['player' => $player, 'session' => $session]);                
                }
                else {
                    $session = $player->gameSession;
                    return response()->json(['player' => $player, 'session' => $session]);
                    }
       } 
       
       catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
}
    }
}
