<?php

namespace NextDeveloper\Agenda\Http\Requests\CalendarSubscriptions;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class CalendarSubscriptionsUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'agenda_calendar_id' => 'nullable|exists:agenda_calendars,uuid|uuid',
        'can_write' => 'boolean',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}