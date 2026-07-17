<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Player extends Model
{
    use HasApiTokens;
    protected $fillable = ['name'];

    public function gameSession()
{
    return $this->hasOne(GameSession::class, 'player_id');
}
}
