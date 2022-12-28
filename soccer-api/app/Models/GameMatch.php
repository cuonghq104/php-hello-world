<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMatch extends BaseModel
{
    use HasFactory;

    protected $fillable = ['id_home', 'id_away', 'start_time', 'stadium', 'status'];

    public function home_team() {
        return $this->belongsTo(Team::class, 'id_home', 'id');
    }

     public function away_team() {
         return $this->belongsTo(Team::class, 'id_away', 'id');
     }
}
