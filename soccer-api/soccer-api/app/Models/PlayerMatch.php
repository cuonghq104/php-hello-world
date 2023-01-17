<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerMatch extends Model
{
    use HasFactory;

    protected $fillable = ['id_player', 'id_team_match', 'is_sub', 'position'];

    public function player() {
        return $this->hasOne(Player::class, 'id', 'id_player');
    }

    protected $hidden = ['id_team_match'];
}
