<?php

namespace NextDeveloper\Agenda\Http\Requests\Calendars;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class CalendarsUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string',
        'description' => 'nullable|string',
        'object_id' => 'nullable',
        'object_type' => 'nullable|string',
        'timezone' => 'nullable|string',
        'is_public' => 'boolean',
        'tags' => '',
        'color' => 'nullable|string',
        'calendar_key' => 'nullable|string',
        'source' => 'nullable|string',
        'sync_enabled' => 'boolean',
        'last_sync_status' => 'nullable|string',
        'last_sync_at' => 'nullable|date',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}