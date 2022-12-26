<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMatch extends Model
{
    use HasFactory;

    protected $fillable = ['id_home', 'id_away', 'time_start', 'stadium', 'status'];

    public function home_team() {
        return $this->belongsTo(Team::class, 'id_home', 'id');
    }

    // public function awayTeam() {
    //     return $this->hasOne(Team::class, 'id_away', 'id');
    // }
}
