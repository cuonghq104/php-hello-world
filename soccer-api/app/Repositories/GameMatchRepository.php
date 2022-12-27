<?php

use App\Models\GameMatch;
use App\Repositories\BaseRepository;

class GameMatchRepository extends BaseRepository  implements GameMatchRepositoryInterface {

    public function __construct(GameMatch $gameMatch)
    {
        parent::__construct($gameMatch);
    }
}
