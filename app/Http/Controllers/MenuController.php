<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\GameSession;
use App\Http\Resources\SessionResource;
use App\Http\Resources\PlayerResource;
use App\Services\Menu\LeaderboardService;
use App\Http\Requests\RenameRequest;

class MenuController extends Controller
{
    private LeaderboardService $leaderboardService;

    public function __construct(LeaderboardService $leaderboardService){
        $this->leaderboardService = $leaderboardService;
    }

    public function continueGame(Request $request)
    {
        $player = $request->user();
        $session = $player->gameSession;
        if ($session == null || $session->is_active == 0)
            {
              return response()->json(['status' => 'error', 
              'message' => 'No active session'], 400);
            }
        return response()->json(['status' => 'success',
        'message' => 'Player continue session',
        'data' => new SessionResource($session)], 200);
    }

    public function createGame(Request $request)
    {
        $player = $request->user();
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
        return response()->json(['status' => 'success',
        'message' => 'Player create session',
        'data' => new SessionResource($session)], 200);
    }

    public function renamePlayer(RenameRequest $request)
    {
        $player = $request->user();
        $player->name = $request->input('new_name');
        $player->save();
        return response()->json(['status' => 'success',
        'message' => 'Player renamed',
        'data' => new PlayerResource($player)], 200);
    }

    public function showStats(Request $request)
    {
        $player = $request->user();
        return response()->json(['status' => 'success',
        'message' => 'Show stats',
        'data' => new PlayerResource($player)], 200);
    }

    public function exitMenu(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => 'success',
        'message' => 'Player log out'], 200);
    }

    public function showLeaderboardKolgold(Request $request)
    {
        return response()->json(['status' => 'success',
        'message' => 'Show Leaderboard',
        'data' => $this->leaderboardService->showLeaderboard('top_kol_gold', 'kol_gold', 5)], 200);
    }

    public function showLeaderboardMaxrooms(Request $request)
    {
        return response()->json(['status' => 'success',
        'message' => 'Show Leaderboard',
        'data' => $this->leaderboardService->showLeaderboard('top_max_rooms', 'max_rooms', 5)], 200);
    }

    public function showLeaderboardKolRooms(Request $request)
    {
        return response()->json(['status' => 'success',
        'message' => 'Show Leaderboard',
        'data' => $this->leaderboardService->showLeaderboard('top_kol_rooms', 'kol_rooms', 5)], 200);
    }
}
