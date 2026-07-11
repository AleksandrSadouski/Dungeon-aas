<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\GameSession;
use App\Services\GameService;
use App\Services\RoomFactory;

class GameController extends Controller
{
    public function openRoom(Request $request, GameSession $session)
    {
        $choice = $request->input('choice');
        $gameService = new GameService();
        $roomFactory = new RoomFactory();
        if (empty($session->left) || empty($session->right))
            {
                $rooms = $gameService->generateArrayRooms();
                $rooms = $gameService->WhoIsWho($session, $rooms);
            }
        if ($choice == 'left')
            {
                $roomService = $roomFactory->make($session->left[0]);
                $session = $roomService->process($session, $session->left[1]);
            }
        elseif ($choice == 'right')
            {   
                $roomService = $roomFactory->make($session->right[0]);
                $session = $roomService->process($session, $session->right[1]);
            }
        else return response()->json(['error' => 'Invalid variants'], 400);
            
        if($gameService->isDead($session))
            {
                return response()->json(['message' => 'dead']);
            }

        $rooms = $gameService->generateArrayRooms();
        $rooms = $gameService->WhoIsWho($session, $rooms);

        return response()->json(['session' => $session]);
    }
}
