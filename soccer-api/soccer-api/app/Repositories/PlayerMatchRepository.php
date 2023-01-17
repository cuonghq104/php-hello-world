<?php

namespace App\Repositories;

use App\Data\Repositories\PlayerMatchRepositoryInterface;
use App\Models\PlayerMatch;

class PlayerMatchRepository extends BaseRepository implements PlayerMatchRepositoryInterface
{
    public function __construct(PlayerMatch $playerMatch)
    {
        parent::__construct($playerMatch);
    }

    public function insertByTeam($request): array
    {
        return array_map(function($item) {
            return $this->eloquentBuilder()->create($item);
        }, $request);
    }
}
