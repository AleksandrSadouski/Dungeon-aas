<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\GameSession;
use App\Services\GameService;
use App\Services\GenerateService;
use App\Http\Resources\SessionResource;
use App\Http\Requests\GameRequest;

class GameController extends Controller
{
    private GameService $gameService;
    private GenerateService $generateService;

    public function __construct(GameService $gameService, GenerateService $generateService){
        $this->gameService = $gameService;
        $this->generateService = $generateService;
    }

    public function openRoom(GameRequest $request, GameSession $session)
    {
        if($request->user()->id != $session->player_id)
            {
                return response()->json(['status' => 'error',
                'message' => 'Is not your profile'], 403);
            }
        
        $choice = $request->input('choice');

        if($this->gameService->stopNotActiveSession($session))
            {
                return response()->json(['status' => 'error', 
                'message' => 'Session is not active'], 409);
            }
        
        $session = $this->generateService->preGenerate($session);

        $session = $this->gameService->stepProcess($session, $choice);
            
        if($this->gameService->isDead($session))
            {
                return response()->json(['status' => 'success', 
                'message' => 'Player is dead',
                'data' => new SessionResource($session)], 200);
            }

        $session = $this->generateService->generateArrayRooms($session);
        return response()->json(['status' => 'success', 
        'message' => 'Player continues step',
        'data' => new SessionResource($session)], 200);
    }
}
