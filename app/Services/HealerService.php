<?php
namespace App\Services;

use App\Constants\GameConst;
use App\Models\GameSession;

class HealerService implements RoomInterfaceService
{
        public function process(GameSession $session, string $subtype)
    {
        $session->kol_rooms++;

        switch ($subtype){
        case 'herbs':
            $session->health += 10;
            break;
        case 'potion':
            $session->health += 25;
            break;
        case 'bonesetter':
            $session->health += 50;
            break;
        case 'anatomist':
            $session->health += 100;
            break;
        default:
        break;
        }
         
        if ($session->health > GameConst::MAX_HEALTH)
            {
                $session->health = GameConst::MAX_HEALTH;  
            }
        
        $session->save();
        return $session;
    }   
}