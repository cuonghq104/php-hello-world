<?php

namespace App\Observers;

use App\Models\GameMatch;
use App\Models\TeamMatch;
use App\Repositories\TeamMatchRepository;

class GameMatchObserver
{

    public function __construct(protected TeamMatchRepository $teamMatchRepository)
    {
        // TODO
    }

    /**
     * Handle the GameMatch "created" event.
     *
     * @param  \App\Models\GameMatch  $gameMatch
     * @return void
     */
    public function created(GameMatch $gameMatch)
    {
        $gameMatchAttr = $gameMatch->getAttributes();
        $teamMatchHome = [
            'id_match' => $gameMatchAttr["id"],
            'id_team' => $gameMatchAttr["id_home"],
            'goal_scored' => 0,
            'goal_conceded' => 0
        ];

        $teamMatchAway = [
            'id_match' => $gameMatchAttr["id"],
            'id_team' => $gameMatchAttr["id_away"],
            'goal_scored' => 0,
            'goal_conceded' => 0
        ];

        $this->teamMatchRepository->create($teamMatchHome);
        $this->teamMatchRepository->create($teamMatchAway);
    }

    /**
     * Handle the GameMatch "updated" event.
     *
     * @param  \App\Models\GameMatch  $gameMatch
     * @return void
     */
    public function updated(GameMatch $gameMatch)
    {
        //
    }

    /**
     * Handle the GameMatch "deleted" event.
     *
     * @param  \App\Models\GameMatch  $gameMatch
     * @return void
     */
    public function deleted(GameMatch $gameMatch)
    {
        //
    }

    /**
     * Handle the GameMatch "restored" event.
     *
     * @param  \App\Models\GameMatch  $gameMatch
     * @return void
     */
    public function restored(GameMatch $gameMatch)
    {
        //
    }

    /**
     * Handle the GameMatch "force deleted" event.
     *
     * @param  \App\Models\GameMatch  $gameMatch
     * @return void
     */
    public function forceDeleted(GameMatch $gameMatch)
    {
        //
    }
}
