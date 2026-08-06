<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaderboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
        'name' => $this->name,
        'max_rooms' => $this->when(!empty($this->max_rooms), $this->max_rooms),
        'kol_gold_player' => $this->when(!empty($this->kol_gold), $this->kol_gold),
        'kol_rooms_player' => $this->when(!empty($this->kol_rooms), $this->kol_rooms)];
    }
}