<?php
namespace App\Services;

use App\Models\GameSession;

class EmptyService implements RoomInterfaceService
{
    public function process(GameSession $session, string $subtype)  
    {
        $session->kol_rooms++;
        $session->save();
        return $session;
    } 
}