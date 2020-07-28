<?php

namespace App\Services;

use App\Models\Dictionary;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class EventService
{

    /**
     * @param array $item
     * @return Event
     */
    public function getEvent(array $item): Event
    {
        $entry = new Event();
        $entries[] = (new Event())->fill($item);

    }

}
