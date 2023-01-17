<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['id_player', 'id_match', 'id_team', 'type', 'id_second_player', 'minute'];

    protected $table = 'events';

    protected $hidden = ['id_player', 'id_match', 'id_team', 'id_second_player'];

    public function player() {
        return $this->hasOne(Player::class, 'id', 'id_player');
    }

    public function secondPlayer() {
        return $this->hasOne(Player::class, 'id', 'id_second_player');
    }

    public function match() {
        return $this->hasOne(GameMatch::class, 'id', 'id_match')
            ->with(['away_team:id,name,short_name,coach', 'home_team:id,name,short_name,coach']);
    }

    public function team() {
        return $this->hasOne(Team::class, 'id', 'id_team');
    }
}
