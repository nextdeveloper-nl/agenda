<?php

namespace NextDeveloper\Agenda\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;
                

/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class CalendarEventsQueryFilter extends AbstractQueryFilter
{
    /**
     * Filter by tags
     *
     * @param  $values
     * @return Builder
     */
    public function tags($values)
    {
        $tags = explode(',', $values);

        $search = '';

        for($i = 0; $i < count($tags); $i++) {
            $search .= "'" . trim($tags[$i]) . "',";
        }

        $search = substr($search, 0, -1);

        return $this->builder->whereRaw('tags @> ARRAY[' . $search . ']');
    }

    /**
     * @var Builder
     */
    protected $builder;
    
    public function title($value)
    {
        return $this->builder->where('title', 'like', '%' . $value . '%');
    }
    
    public function description($value)
    {
        return $this->builder->where('description', 'like', '%' . $value . '%');
    }
    
    public function location($value)
    {
        return $this->builder->where('location', 'like', '%' . $value . '%');
    }
    
    public function timezone($value)
    {
        return $this->builder->where('timezone', 'like', '%' . $value . '%');
    }
    
    public function status($value)
    {
        return $this->builder->where('status', 'like', '%' . $value . '%');
    }
    
    public function meetingLink($value)
    {
        return $this->builder->where('meeting_link', 'like', '%' . $value . '%');
    }
    
    public function externalEventId($value)
    {
        return $this->builder->where('external_event_id', 'like', '%' . $value . '%');
    }

    public function isOutOfOffice($value)
    {
        if(!is_bool($value)) {
            $value = false;
        }

        return $this->builder->where('is_out_of_office', $value);
    }

    public function isAppointmentSlot($value)
    {
        if(!is_bool($value)) {
            $value = false;
        }

        return $this->builder->where('is_appointment_slot', $value);
    }

    public function isAllDay($value)
    {
        if(!is_bool($value)) {
            $value = false;
        }

        return $this->builder->where('is_all_day', $value);
    }

    public function startsAtStart($date)
    {
        return $this->builder->where('starts_at', '>=', $date);
    }

    public function startsAtEnd($date)
    {
        return $this->builder->where('starts_at', '<=', $date);
    }

    public function endsAtStart($date)
    {
        return $this->builder->where('ends_at', '>=', $date);
    }

    public function endsAtEnd($date)
    {
        return $this->builder->where('ends_at', '<=', $date);
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

    public function agendaCalendarId($value)
    {
            $agendaCalendar = \NextDeveloper\Agenda\Database\Models\Calendars::where('uuid', $value)->first();

        if($agendaCalendar) {
            return $this->builder->where('agenda_calendar_id', '=', $agendaCalendar->id);
        }
    }

    public function externalEventId($value)
    {
            $externalEvent = \NextDeveloper\\Database\Models\ExternalEvents::where('uuid', $value)->first();

        if($externalEvent) {
            return $this->builder->where('external_event_id', '=', $externalEvent->id);
        }
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
