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

    public function team_list() {
        return $this->hasMany(PlayerMatch::class, 'id_team_match', 'id');
    }

}
