<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['name'];

    public function gameSession()
{
    return $this->hasOne(GameSession::class, 'player_id');
}
}
