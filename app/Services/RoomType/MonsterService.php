<?php
namespace App\Services\RoomType;

use App\Constants\GameConst;
use App\Models\GameSession;

class MonsterService implements RoomInterfaceService
{
        public function process(GameSession $session, string $subtype): GameSession
    {
        $session->kol_rooms++;

        switch ($subtype){
        case 'shrekell':
            $session->armor -= 25;
            break;
        case 'tormin':
            $session->armor -= 50;
            break;
        case 'grosstroyts':
            $session->armor -= 70;
            break;
        default:
        break;
        }
         
        if ($session->armor < GameConst::MIN_ARMOR)
            {
                $session->health = $session->health + $session->armor;
                $session->armor = 0;
            }
        
        $session->save();
        return $session;
    }   
}