<?php
namespace App\Services\GameProcess;

use App\Models\GameSession;

interface RoomInterfaceService
{
    public function process(GameSession $session, string $subtype): GameSession;
}