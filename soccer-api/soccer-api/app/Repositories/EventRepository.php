<?php

namespace App\Repositories;

use App\Data\Repositories\EventRepositoryInterface;
use App\Models\Event;

class EventRepository extends BaseRepository implements EventRepositoryInterface
{
    public function __construct(Event $event)
    {
        parent::__construct($event);
    }

}
