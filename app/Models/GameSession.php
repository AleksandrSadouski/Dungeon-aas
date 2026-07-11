<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    protected $fillable = [];
    protected $casts = ['left' => 'array', 'right' => 'array'];

    public function player()
{
    return $this->belongsTo(Player::class, 'player_id');
}
}
