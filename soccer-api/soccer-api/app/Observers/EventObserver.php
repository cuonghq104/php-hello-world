<?php

namespace App\Observers;

use App\Data\Repositories\EventRepositoryInterface;
use App\Data\Repositories\GameMatchRepositoryInterface;
use App\Data\Repositories\TeamMatchRepositoryInterface;
use App\Models\Event;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */

    public function __construct(
        protected EventRepositoryInterface $eventRepository,
        protected GameMatchRepositoryInterface $gameMatchRepository,
        protected TeamMatchRepositoryInterface $teamMatchRepository
    )
    {

    }

    private function getMatchData($data): array
    {
        $idMatch = $data['id_match'];
        return $this->gameMatchRepository->findOrFail($idMatch)->getAttributes();
    }


    private function updateTeamMatchData($idTeam, $idMatch, $goalScored, $goalReceived): void
    {
        $query = $this->teamMatchRepository
            ->eloquentBuilder()
            ->where('id_team', $idTeam)
            ->where('id_match', $idMatch)
            ->first();

        $data = $query->getAttributes();
        $data["goal_scored"] = $goalScored;
        $data["goal_conceded"] = $goalReceived;

        $this->teamMatchRepository->update($data['id'], $data);
    }

    private function totalTeamGoal($idMatch, $idTeam): int
    {
        return $this->eventRepository->queryBuilder()->where('id_match', $idMatch)->where('id_team', $idTeam)->count();
    }

    public function created(Event $event): void
    {
        //
        $data = $event->getAttributes();
        if ($data['type'] === 'goal') {
            $match = $this->getMatchData($data);
            $idHome = $match["id_home"];
            $idAway = $match["id_away"];

            $totalHomeTeamGoal = $this->totalTeamGoal($data['id_match'], $idHome);
            $totalAwayTeamGoal = $this->totalTeamGoal($data['id_match'], $idAway);

            $this->updateTeamMatchData($idHome, $data['id_match'], $totalHomeTeamGoal, $totalAwayTeamGoal);
            $this->updateTeamMatchData($idAway, $data['id_match'], $totalAwayTeamGoal, $totalHomeTeamGoal);
        }
    }

    /**
     * Handle the Event "updated" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function updated(Event $event)
    {
        //
    }

    /**
     * Handle the Event "deleted" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function deleted(Event $event)
    {
        //
    }

    /**
     * Handle the Event "restored" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function restored(Event $event)
    {
        //
    }

    /**
     * Handle the Event "force deleted" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function forceDeleted(Event $event)
    {
        //
    }
}
