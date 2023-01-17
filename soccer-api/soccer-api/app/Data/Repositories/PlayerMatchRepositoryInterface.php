<?php

namespace App\Data\Repositories;

interface PlayerMatchRepositoryInterface extends BaseRepositoryInterface
{
    public function insertByTeam($request);
}
