<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMatch extends Model
{
    use HasFactory;
    use Compoships;

    protected $fillable = ['id_team', 'id_match', 'goal_scored', 'goal_conceded'];

    public function team_list()
    {
        return $this->hasMany(PlayerMatch::class, 'id_team_match', 'id')
            ->with(['player' => fn($q) => $q->select('id', 'name', 'nationality', 'date_of_birth', 'position', 'detail_position', 'squad_number')])
            ->select('id_player', 'id_team_match', 'is_sub', 'position');
    }

    public function team() {
        return $this->hasOne(Team::class, 'id', 'id_team');
    }

}
