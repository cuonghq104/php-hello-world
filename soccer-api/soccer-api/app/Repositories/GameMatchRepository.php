<?php

namespace App\Repositories;

use App\Data\Repositories\GameMatchRepositoryInterface;
use App\Models\GameMatch;

class GameMatchRepository extends BaseRepository implements GameMatchRepositoryInterface
{

    public function __construct(GameMatch $gameMatch)
    {
        parent::__construct($gameMatch);
    }

    function gameMatchDetailData(int $id, $col = ["*"])
    {
        $data = $this->findOrFail($id, $col);
        $data->load('home_stats:id,id_team,id_match,goal_scored');
        $data->load('away_stats:id,id_team,id_match,goal_scored');
        return $data;
    }
}
