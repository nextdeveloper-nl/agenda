<?php

namespace NextDeveloper\Agenda\Http\Requests\TaskAssignees;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class TaskAssigneesCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'agenda_task_item_id' => 'required|exists:agenda_task_items,uuid|uuid',
            'iam_user_id' => 'required|exists:iam_users,uuid|uuid',
        'comment' => 'nullable|string',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}