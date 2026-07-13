<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SessionResource;

class PlayerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['player_id' => $this->id,
        'name' => $this->name,
        'kol_game' => $this->kol_game,
        'max_rooms' => $this->max_rooms,
        'max_gold' => $this->max_gold,
        'kol_gold_player' => $this->kol_gold,
        'session' => new SessionResource ($this->whenLoaded('gameSession'))];
    }
}