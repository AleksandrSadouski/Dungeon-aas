<?php
namespace App\Services;

use App\Models\Player;
use App\Models\GameSession;
use App\Constants\GameConst;
use App\Constants\ChanceConst;

class GameService
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
        $randNum = mt_rand(0, array_sum($arrTS));
        while($randNum > $cumulative[$i])
            {
                $i++;
            }
        $keys = array_keys($arrTS);
        $elTS = $keys[$i];
        return $elTS;
    }

    private function vyborSubtype($type): array
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
        $subtypes = $this->vyborSubtype($type);
        $subtype = $this->generateCumSum($subtypes);
        $room = [$type, $subtype];
        return $room;
    }

    public function generateArrayRooms(): array
    {
        $roomX = $this->generateRoom();
        $roomY = $this->generateRoom(); 
        while ($roomY[0] == $roomX[0])
            {
                $roomY = $this->generateRoom();
            }
        $rooms = [$roomX, $roomY];
        return $rooms;
    }

    public function WhoisWho(GameSession $session, array $rooms): array
    {
        shuffle($rooms);
        $session->left = $rooms[0];
        $session->right = $rooms[1];
        $session->save();
        return $rooms;
    }
    
    public function isDead(GameSession $session): bool
    {
        if ($session->health <= 0)
            {
                $session->is_active = 0;
                $player = $session->player;
                $player->kol_gold += $session->kol_gold;
                $player->kol_game++;
                if ($session->kol_gold > $player->max_gold)
                    {$player->max_gold = $session->kol_gold;}
                if ($session->kol_rooms > $player->max_rooms)
                    {$player->max_rooms = $session->kol_rooms;}
                $player->save();
                $session->delete();
                return true;
            }
            else return false;
    }

}