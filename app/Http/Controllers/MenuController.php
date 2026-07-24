<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\GameSession;
use App\Http\Resources\SessionResource;
use App\Http\Resources\LeaderboardResource;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
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

    public function exitMenu(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => 'success',
        'message' => 'Player log out'], 200);
    }

    public function showLeaderboardKolgold(Request $request)
    {
        $players = Cache::remember('top_kol_gold', 240, function () {
            return Player::orderBy('kol_gold', 'desc')->select('name', 'kol_gold')->limit(5)->get();
            });
        return response()->json(['status' => 'success',
        'message' => 'Show Leaderboard',
        'data' => LeaderboardResource::collection($players)], 200);
    }

        public function showLeaderboardMaxrooms(Request $request)
    {
        $players = Cache::remember('top_max_rooms', 240, function () {
            return Player::orderBy('max_rooms', 'desc')->select('name', 'max_rooms')->limit(5)->get();
            });
        return response()->json(['status' => 'success',
        'message' => 'Show Leaderboard',
        'data' => LeaderboardResource::collection($players)], 200);
    }
}
