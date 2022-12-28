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
        $data->load("home_team:id,name,city");
        $data->load("away_team:id,name,city");
        return $data;
    }
}
