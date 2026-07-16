<?php
namespace App\Services;

use App\Models\Player;
use App\Models\GameSession;
use App\Constants\GameConst;
use App\Constants\ChanceConst;
use App\Services\RoomFactory;
use App\Services\GenerateService;
use Illuminate\Support\Facades\DB;

class GameService
{
    private RoomFactory $roomFactory;

    public function __construct(RoomFactory $roomFactory)
    {
        $this->roomFactory = $roomFactory;
    }

    public function stopNotActiveSession(GameSession $session): bool
    {
        if ($session->is_active == 0)
            {return true;}
        return false;
    }

    public function stepProcess(GameSession $session, string $choice): GameSession
    {
        if ($choice == 'left')
            {
                $roomService = $this->roomFactory->make($session->left[0]);
                $session = $roomService->process($session, $session->left[1]);
            }
        elseif ($choice == 'right')
            {   
                $roomService = $this->roomFactory->make($session->right[0]);
                $session = $roomService->process($session, $session->right[1]);
            }
        $session->left = [];
        $session->right = [];
        $session->save();
        return $session;    
    }
    
    public function isDead(GameSession $session): bool
    {
        if ($session->health <= GameConst::MIN_HEALTH)
            {
                DB::transaction(function() use ($session) 
                {$this->saveStat($session);});
                return true;
            }
            else return false;
    }

    private function saveStat(GameSession $session): void
    {
        $session->is_active = 0;
        $session->health = GameConst::MIN_HEALTH;
        $player = $session->player;
        $player->kol_gold += $session->kol_gold;
        $player->kol_game++;
        if ($session->kol_gold > $player->max_gold)
            {$player->max_gold = $session->kol_gold;}
        if ($session->kol_rooms > $player->max_rooms)
            {$player->max_rooms = $session->kol_rooms;}
        $player->save();
        $session->save();     
    }
}