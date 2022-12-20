<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nationality', 'date_of_birth', 'position', 'detail_position', 'squad_number', 'id_team'];
}
