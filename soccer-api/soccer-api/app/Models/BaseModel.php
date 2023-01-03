<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    function scopeSearchByName($query, $request) {
        if ($search = $request->search) {
            return $query->where('name', 'like', $search . '%');
        }

        return $query;
    }
}
