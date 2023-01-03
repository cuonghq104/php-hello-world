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

}
