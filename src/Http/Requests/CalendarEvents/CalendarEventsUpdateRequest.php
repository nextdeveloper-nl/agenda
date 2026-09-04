<?php

namespace NextDeveloper\Agenda\Http\Requests\CalendarEvents;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class CalendarEventsUpdateRequest extends AbstractFormRequest
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
        'timezone' => 'nullable|string',
        'is_all_day' => 'boolean',
        'status' => 'nullable|string',
        'meeting_link' => 'nullable|string',
        'data' => 'nullable',
        'external_event_id' => 'nullable|string|exists:external_events,uuid|uuid',
        'rrule' => 'nullable|string',
        'rrule_options' => 'nullable',
        'cron_expression' => 'nullable|string',
        'yearly_notification_cron' => 'nullable|string',
        'frequency' => 'nullable|string|in:yearly,monthly,weekly,daily,hourly',
        'frequency_variant' => 'nullable|string',
        'repeat_interval' => 'nullable|integer',
        'occurrence_count' => 'nullable|integer',
        'is_infinite' => 'boolean',
        'is_repeat' => 'boolean',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}