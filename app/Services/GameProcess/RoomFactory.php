<?php
namespace App\Services\GameProcess;

use App\Services\MonsterService;
use App\Services\HealerService;
use App\Services\ArmorService;
use App\Services\ChestService;
use App\Services\EmptyService;

class RoomFactory
{
    private MonsterService $monsterService;
    private HealerService $healerService;
    private ArmorService $armorService;
    private ChestService $chestService;
    private EmptyService $emptyService;

    public function __construct(MonsterService $monsterService, HealerService $healerService,
    ArmorService $armorService, ChestService $chestService, EmptyService $emptyService)
    {
        $this->monsterService = $monsterService;
        $this->healerService = $healerService;
        $this->armorService = $armorService;
        $this->chestService = $chestService;
        $this->emptyService = $emptyService;
    }

    public function make(string $type): RoomInterfaceService
    {
        switch($type)
        {
            case 'monster':
                return $this->monsterService;
            case 'healer':
                return $this->healerService;
            case 'armor':
                return $this->armorService;
            case 'chest':
                return $this->chestService;
            case 'empty':
                return $this->emptyService;
            default:
                return $this->emptyService;
        }
    }
}