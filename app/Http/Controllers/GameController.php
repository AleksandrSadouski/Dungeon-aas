<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\GameSession;
use App\Services\GameService;
use App\Http\Resources\SessionResource;
use App\Http\Requests\GameRequest;

class GameController extends Controller
{
    public function openRoom(GameRequest $request, GameSession $session)
    {
        $choice = $request->input('choice');
        $gameService = new GameService();

        $session = $gameService->preGenerate($session);

        $session = $gameService->leftOrRight($session, $choice);
            
        if($gameService->isDead($session))
            {
                return new SessionResource($session);
            }

        $session = $gameService->generateArrayRooms($session);
        return new SessionResource($session);
    }
}
