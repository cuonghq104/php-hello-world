<?php

namespace App\Repositories;

use App\Data\Repositories\TeamMatchRepositoryInterface;
use App\Models\TeamMatch;

class TeamMatchRepository extends BaseRepository implements TeamMatchRepositoryInterface
{
    public function __construct(TeamMatch $teamMatch)
    {
        parent::__construct($teamMatch);
    }
}
