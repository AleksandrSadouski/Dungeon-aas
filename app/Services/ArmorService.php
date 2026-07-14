<?php
namespace App\Services;

use App\Models\Player;
use App\Models\GameSession;
use App\Constants\GameConst;

class ArmorService implements RoomInterfaceService
{
    public function process(GameSession $session, string $subtype): GameSession
    {
        $session->kol_rooms++;

        switch ($subtype){
        case 'chainmail':
            $session->armor += 25;
            break;
        case 'ironclad':
            $session->armor += 50;
            break;
        default:
        break;
        }

        if ($session->armor > GameConst::MAX_ARMOR)
        {
            $session->armor = GameConst::MAX_ARMOR;
        }

        $session->save();
        return $session;       
    }
    
}