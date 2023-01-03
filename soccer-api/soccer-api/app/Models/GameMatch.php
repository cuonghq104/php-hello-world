<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameMatch extends BaseModel
{
    use HasFactory;
    use Compoships;

    protected $fillable = ['id_home', 'id_away', 'start_time', 'stadium', 'status'];

    public function home_team() {
        return $this->belongsTo(Team::class, 'id_home', 'id');
    }

     public function away_team() {
         return $this->belongsTo(Team::class, 'id_away', 'id');
     }

     public function home_stats() {
        return $this->hasOne(TeamMatch::class, ['id_match', 'id_team'], ['id', 'id_home'])->with(['team_list' => function($q) {
            $q->join('players', 'players.id', '=', 'id_player')->select('id_player as id', 'id_team_match', 'name', 'date_of_birth', 'nationality');
        }]);
     }

     public function away_stats() {
         return $this->hasOne(TeamMatch::class, ['id_match', 'id_team'], ['id', 'id_away'])->with('team_list');
     }

}
