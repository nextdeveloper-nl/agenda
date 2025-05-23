<?php

namespace NextDeveloper\Agenda\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;
            

/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class CalendarEventAttendeesQueryFilter extends AbstractQueryFilter
{

    /**
     * @var Builder
     */
    protected $builder;
    
    public function comment($value)
    {
        return $this->builder->where('comment', 'like', '%' . $value . '%');
    }

    public function isOrganizer($value)
    {
        if(!is_bool($value)) {
            $value = false;
        }

        return $this->builder->where('is_organizer', $value);
    }

    public function isOptional($value)
    {
        if(!is_bool($value)) {
            $value = false;
        }

        return $this->builder->where('is_optional', $value);
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

    public function agendaCalendarEventId($value)
    {
            $agendaCalendarEvent = \NextDeveloper\Agenda\Database\Models\CalendarEvents::where('uuid', $value)->first();

        if($agendaCalendarEvent) {
            return $this->builder->where('agenda_calendar_event_id', '=', $agendaCalendarEvent->id);
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
