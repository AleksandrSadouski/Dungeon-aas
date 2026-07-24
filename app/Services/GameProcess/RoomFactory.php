<?php
namespace App\Services\GameProcess;

use App\Services\MonsterService;
use App\Services\HealerService;
use App\Services\ArmorService;
use App\Services\ChestService;
use App\Services\EmptyService;

class RoomFactory
{
    public function make(string $type): RoomInterfaceService
    {
        switch($type)
        {
            case 'monster':
                return app(MonsterService::class);
            case 'healer':
                return app(HealerService::class);
            case 'armor':
                return app(ArmorService::class);
            case 'chest':
                return app(ChestService::class);
            case 'empty':
                return app(EmptyService::class);
            default:
                return app(EmptyService::class);
        }
    }
}