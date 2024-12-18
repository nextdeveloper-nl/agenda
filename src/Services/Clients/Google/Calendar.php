<?php

namespace NextDeveloper\Agenda\Services\Clients\Google;


use Google\Service\Exception;
use InvalidArgumentException;

class Calendar extends Init
{
    private \Google_Service_Calendar $service;

    public function __construct($token)
    {
        parent::__construct($token);
        $this->service = new \Google_Service_Calendar($this->client);
    }

    /**
     * Retrieves list of calendars
     *
     * @throws Exception
     * @return array
     */
    public function getCalendars(): array
    {
        $list = $this->service->calendarList->listCalendarList();
        $items = $list->getItems();

        return array_map(function($item) {
            return [
                'calendar_key'          => $item->getId(),
                'name'                  => $item->getSummary(),
                'description'           => $item->getDescription(),
                'timezone'              => $item->getTimeZone(),
                'color'                 => $item->getBackgroundColor(),
            ];
        }, $items);
    }

    /**
     * Retrieves events for a specific calendar
     *
     * @param string $calendarId
     * @param array $params
     * @throws Exception|InvalidArgumentException
     * @return array
     */
    public function getEvents(string $calendarId, array $params = []): array
    {
        $lists = $this->service->events->listEvents($calendarId, $params);
        $items = $lists->getItems();
        $events = [];

        foreach ($items as $item) {

            // Skip events with null title or start date
            if (!$item->getStart()?->getDateTime()) {
                continue;
            }

            $event = [
                'external_event_id'         => $item->getId(),
                'title'                     => $item->getSummary(),
                'description'               => $item->getDescription(),
                'location'                  => $item->getLocation(),
                'starts_at'                 => $item->getStart()?->getDateTime(),
                'ends_at'                   => $item->getEnd()?->getDateTime(),
                'timezone'                  => $item->getStart()?->getTimeZone(),
                'is_all_day'                => (bool)$item->getStart()?->getDate(),
                'status'                    => $item->getStatus(),
                'meeting_link'              => $item->getHangoutLink(),
                'data'                      => json_encode($item),
                'attendees'                 => []
            ];

            // Process attendees if they exist
            if ($item->getAttendees()) {
                foreach ($item->getAttendees() as $attendee) {
                    $event['attendees'][] = [
                        'email'                 => $attendee->getEmail(),
                        'name'                  => $attendee->getDisplayName(),
                        'response_status'       => $attendee->getResponseStatus(),
                        'is_organizer'          => $attendee->getOrganizer() ?? false,
                        'is_optional'           => $attendee->getOptional() ?? false,
                        'comment'               => $attendee->getComment(),
                    ];
                }
            }

            $events[] = $event;
        }

        return $events;
    }
}