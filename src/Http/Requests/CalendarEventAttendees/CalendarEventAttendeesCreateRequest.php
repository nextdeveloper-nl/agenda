<?php

namespace NextDeveloper\Agenda\Http\Requests\CalendarEventAttendees;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class CalendarEventAttendeesCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable',
        'email' => 'nullable',
        'response_status' => 'nullable',
        'is_organizer' => 'boolean',
        'is_optional' => 'boolean',
        'comment' => 'nullable|string',
        'agenda_calendar_event_id' => 'required|exists:agenda_calendar_events,uuid|uuid',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}