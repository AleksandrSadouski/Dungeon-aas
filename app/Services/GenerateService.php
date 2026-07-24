<?php
namespace App\Services;

use App\Models\Player;
use App\Models\GameSession;
use App\Constants\GameConst;
use App\Constants\ChanceConst;
use App\Services\RoomFactory;

class GenerateService
{
    private function generateCumSum(array $arrTS): string
    {
        $i = 0;
        $cumulative = [];
        foreach ($arrTS as $value){
            if ($i > 0){
            $cumulative[$i] = $cumulative[$i-1] + $value;}
            else $cumulative[$i] = $value;
            $i++;
        }
        $i = 0;
        $randNum = random_int(0, array_sum($arrTS));
        while($randNum > $cumulative[$i])
            {
                $i++;
            }
        $keys = array_keys($arrTS);
        $elTS = $keys[$i];
        return $elTS;
    }

    private function selectSubtype($type): array
    {
        switch ($type){
        case 'monster': $subtypes = ChanceConst::CHANCE_SUBTYPES_MONSTER;
        return $subtypes;
        case 'chest': $subtypes = ChanceConst::CHANCE_SUBTYPES_CHEST;
        return $subtypes;
        case 'healer': $subtypes = ChanceConst::CHANCE_SUBTYPES_HEALER;
        return $subtypes;
        case 'armor': $subtypes = ChanceConst::CHANCE_SUBTYPES_ARMOR;
        return $subtypes;
        default: $subtypes = ChanceConst::CHANCE_SUBTYPES_EMPTY;
        return $subtypes;
        }
    }

    private function generateRoom(): array
    {
        $room = [];
        $type = $this->generateCumSum(ChanceConst::CHANCE_TYPES);
        $subtypes = $this->selectSubtype($type);
        $subtype = $this->generateCumSum($subtypes);
        $room = [$type, $subtype];
        return $room;
    }

    public function generateArrayRooms(GameSession $session): GameSession
    {
        $roomX = $this->generateRoom();
        $roomY = $this->generateRoom(); 
        while ($roomY[0] == $roomX[0])
            {
                $roomY = $this->generateRoom();
            }
        $rooms = [$roomX, $roomY];
        shuffle($rooms);
        $session->left = $rooms[0];
        $session->right = $rooms[1];
        $session->save();
        return $session;
    }

    public function preGenerate(GameSession $session): GameSession
    {
        if (empty($session->left) || empty($session->right))
            {
                $session = $this->generateArrayRooms($session);
            }
        return $session;
    }
}