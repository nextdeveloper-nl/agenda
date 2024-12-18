<?php

namespace NextDeveloper\Agenda\Http\Requests\CalendarEvents;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class CalendarEventsCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'nullable|string',
        'description' => 'nullable|string',
        'location' => 'nullable|string',
        'guests' => 'nullable',
        'starts_at' => 'required|date',
        'ends_at' => 'required|date',
        'agenda_calendar_id' => 'required|exists:agenda_calendars,uuid|uuid',
        'is_out_of_office' => 'boolean',
        'is_appointment_slot' => 'boolean',
        'tags' => 'nullable',
        'timezone' => 'nullable|string',
        'is_all_day' => 'boolean',
        'status' => 'nullable|string',
        'meeting_link' => 'nullable|string',
        'data' => 'nullable',
        'external_event_id' => 'nullable|string|exists:external_events,uuid|uuid',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}