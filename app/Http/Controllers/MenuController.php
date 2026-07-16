<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\GameSession;
use App\Http\Resources\SessionResource;

class MenuController extends Controller
{
    public function continueGame(Player $player)
    {
        $session = $player->gameSession;
        if ($session == null || $session->is_active == 0)
            {
              return response()->json(['error' => 'No active session'], 400);
            }
        return new SessionResource($session);
    }

    public function createGame(Player $player)
    {
        $session = $player->gameSession;
        if ($session != null)
            {
                $session->delete();
            }
        $session = new GameSession();
        $session->player_id = $player->id;
        $session->left = [];
        $session->right = [];
        $session->save();
        return new SessionResource($session);
    }
}
