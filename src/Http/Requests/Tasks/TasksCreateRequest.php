<?php

namespace NextDeveloper\Agenda\Http\Requests\Tasks;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class TasksCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
        'description' => 'nullable|string',
        'color' => 'nullable|string',
        'google_id' => 'nullable|string',
        'is_default' => 'boolean',
        'object_type' => 'nullable|string',
        'object_id' => 'nullable',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}