<?php

namespace App\Repositories;

use App\Data\Repositories\PlayerRepositoryInterface;
use App\Models\GameMatch;
use App\Models\Player;

class PlayerRepository extends BaseRepository implements PlayerRepositoryInterface
{
    public function __construct(Player $player)
    {
        parent::__construct($player);
    }

}
