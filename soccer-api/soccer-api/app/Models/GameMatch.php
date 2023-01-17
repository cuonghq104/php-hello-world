<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameMatch extends BaseModel
{
    use HasFactory;
    use Compoships;

    protected $fillable = ['id_home', 'id_away', 'start_time', 'stadium', 'status'];
    protected $hidden = ['id_home', 'id_away'];
    public function home_team() {
        return $this->belongsTo(Team::class, 'id_home', 'id');
    }

     public function away_team() {
         return $this->belongsTo(Team::class, 'id_away', 'id');
     }

     public function home_stats() {
         return $this
             ->hasOne(TeamMatch::class, ['id_match', 'id_team'], ['id', 'id_home'])
             ->with([
                 'team_list' => fn($q) => $q->select('id_player', 'is_sub', 'id_team_match'),
                 'team' => fn($q) => $q->select('id', 'name', 'short_name', 'coach')
             ]);
     }

     public function away_stats() {
         return $this->hasOne(TeamMatch::class, ['id_match', 'id_team'], ['id', 'id_away'])->with('team_list');
     }


}
