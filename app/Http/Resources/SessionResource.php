<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['session_id' => $this->id,
        'player_id' => $this->player_id,
        'health' => $this->health,
        'armor' => $this->armor,
        'kol_rooms' => $this->kol_rooms,
        'kol_gold_session' => $this->kol_gold,
        'is_active' => $this->is_active];
    }
}