<?php

namespace NextDeveloper\Agenda\Http\Requests\CalendarItems;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class CalendarItemsUpdateRequest extends AbstractFormRequest
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
        'starts_at' => 'nullable|date',
        'ends_at' => 'nullable|date',
        'agenda_calendar_id' => 'nullable|exists:agenda_calendars,uuid|uuid',
        'is_out_of_office' => 'boolean',
        'is_appointment_slot' => 'boolean',
        'tags' => 'nullable',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}