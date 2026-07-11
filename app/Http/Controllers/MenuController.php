<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\GameSession;

class MenuController extends Controller
{
    public function continueGame(Player $player)
    {
        try {
        $session = $player->gameSession;
        return response()->json(['session' => $session]);}
        
        catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);}
    }

    public function createGame(Player $player)
    {
        try {
        $session = $player->gameSession;
        if ($session != null)
            {
                $session->delete();
            }
        $session = new GameSession();
        $session->player_id = $player->id;
        $session->save();
        return response()->json(['session' => $session]);}
        
        catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);}
    }
}
