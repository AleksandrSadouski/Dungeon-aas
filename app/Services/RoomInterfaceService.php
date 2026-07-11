<?php
namespace App\Services;

use App\Models\GameSession;

interface RoomInterfaceService
{
    public function process(GameSession $session, string $subtype): GameSession;
}