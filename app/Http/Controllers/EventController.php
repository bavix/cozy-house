<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventBeaconRequest;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Requests\EventRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Event;

class EventController extends Controller
{

    /**
     * @param EventRequest $eventRequest
     * @return JsonResponse
     */
    public function store(EventRequest $eventRequest)//: JsonResponse
    {
        /**
         * @var $token PersonalAccessToken
         */
        $token = $eventRequest->user()->currentAccessToken();
        [$appName, $device] = \explode(':', $token->name, 2);
        $defaults = [
            'user_id' => $eventRequest->user()->getKey(),
            'token_id' => $token->getKey(),
            'app_name' => $appName,
            'device' => $device,
            'client_ip' => $eventRequest->getClientIp(),
            'request_url' => (string)$eventRequest->header('referer'),
            'user_agent' => (string)$eventRequest->userAgent(),
        ];

        foreach ($eventRequest->validated() as $item) {
            $entry = new Event();
            $entry->fill(\array_merge(
                $defaults,
                ['date' => $item['datetime']],
                $item,
                ['referral_url' => (string)$item['referral_url']],
                $eventRequest->cookie()
            ));

            $entry->save();
        }

        return response()->json(['result' => true], 201);;
    }

    /**
     * @param EventBeaconRequest $eventBeaconRequest
     * @return JsonResponse
     */
    public function sendBeacon(EventBeaconRequest $eventBeaconRequest): JsonResponse
    {
        $eventRequest = EventRequest::createFrom($eventBeaconRequest);
        if (!$eventRequest) {
            return response()
                ->json(['result' => false], 422);
        }

        $eventRequest->replace($eventBeaconRequest->input('events'));
        $eventValidator = \Validator::make($eventRequest->input(), $eventRequest->rules());
        $eventRequest->setValidator($eventValidator);

        return $this->store($eventRequest);
    }

}
