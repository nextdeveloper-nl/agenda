<?php

namespace NextDeveloper\Agenda\Http\Requests\TaskItems;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class TaskItemsCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'agenda_task_id' => 'required|exists:agenda_tasks,uuid|uuid',
        'google_id' => 'nullable|string',
        'title' => 'required|string',
        'notes' => 'nullable|string',
        'status' => 'string',
        'due' => 'nullable|date',
        'completed_at' => 'nullable|date',
        'priority' => 'integer',
        'position' => 'integer',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}