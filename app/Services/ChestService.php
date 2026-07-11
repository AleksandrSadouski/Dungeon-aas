<?php
namespace App\Services;

use App\Models\GameSession;

class ChestService implements RoomInterfaceService
{
    public function process(GameSession $session, string $subtype)
    {
        $session->kol_rooms++;

        switch ($subtype){
        case 'wooden':
            $session->kol_gold += 10;
            break;
        case 'iron':
            $session->kol_gold += 30;
            break;
        case 'golden':
            $session->kol_gold += 50;
            break;
        case 'diamond':
            $session->kol_gold += 100;
            break;
        default:
        break;
        }
        $session->save();
        return $session;
    }
}