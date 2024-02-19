<?php

namespace NextDeveloper\Agenda\Http\Requests\Calendars;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class CalendarsCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string',
        'description' => 'nullable|string',
        'object_id' => 'required',
        'object_type' => 'required|string',
        'timezone' => 'required|string',
        'is_public' => 'boolean',
        'tags' => '',
        'color' => 'nullable|string',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}