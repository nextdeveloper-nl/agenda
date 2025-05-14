<?php

namespace NextDeveloper\Agenda\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;
                

/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class TaskItemsQueryFilter extends AbstractQueryFilter
{

    /**
     * @var Builder
     */
    protected $builder;

    public function googleId($value)
    {
        return $this->builder->where('google_id', 'like', '%' . $value . '%');
    }
    
    public function title($value)
    {
        return $this->builder->where('title', 'like', '%' . $value . '%');
    }
    
    public function notes($value)
    {
        return $this->builder->where('notes', 'like', '%' . $value . '%');
    }
    
    public function status($value)
    {
        return $this->builder->where('status', 'like', '%' . $value . '%');
    }

    public function priority($value)
    {
        $operator = substr($value, 0, 1);

        if ($operator != '<' || $operator != '>') {
            $operator = '=';
        } else {
            $value = substr($value, 1);
        }

        return $this->builder->where('priority', $operator, $value);
    }

    public function position($value)
    {
        $operator = substr($value, 0, 1);

        if ($operator != '<' || $operator != '>') {
            $operator = '=';
        } else {
            $value = substr($value, 1);
        }

        return $this->builder->where('position', $operator, $value);
    }

    public function dueStart($date)
    {
        return $this->builder->where('due', '>=', $date);
    }

    public function dueEnd($date)
    {
        return $this->builder->where('due', '<=', $date);
    }

    public function completedAtStart($date)
    {
        return $this->builder->where('completed_at', '>=', $date);
    }

    public function completedAtEnd($date)
    {
        return $this->builder->where('completed_at', '<=', $date);
    }

    public function createdAtStart($date)
    {
        return $this->builder->where('created_at', '>=', $date);
    }

    public function createdAtEnd($date)
    {
        return $this->builder->where('created_at', '<=', $date);
    }

    public function updatedAtStart($date)
    {
        return $this->builder->where('updated_at', '>=', $date);
    }

    public function updatedAtEnd($date)
    {
        return $this->builder->where('updated_at', '<=', $date);
    }

    public function deletedAtStart($date)
    {
        return $this->builder->where('deleted_at', '>=', $date);
    }

    public function deletedAtEnd($date)
    {
        return $this->builder->where('deleted_at', '<=', $date);
    }

    public function agendaTaskId($value)
    {
            $agendaTask = \NextDeveloper\Agenda\Database\Models\Tasks::where('uuid', $value)->first();

        if($agendaTask) {
            return $this->builder->where('agenda_task_id', '=', $agendaTask->id);
        }
    }

    public function iamUserId($value)
    {
            $iamUser = \NextDeveloper\IAM\Database\Models\Users::where('uuid', $value)->first();

        if($iamUser) {
            return $this->builder->where('iam_user_id', '=', $iamUser->id);
        }
    }

    public function iamAccountId($value)
    {
            $iamAccount = \NextDeveloper\IAM\Database\Models\Accounts::where('uuid', $value)->first();

        if($iamAccount) {
            return $this->builder->where('iam_account_id', '=', $iamAccount->id);
        }
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
