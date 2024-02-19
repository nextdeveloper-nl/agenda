<?php

namespace NextDeveloper\Agenda\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;
        

/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class CalendarSubscriptionsQueryFilter extends AbstractQueryFilter
{
    /**
     * @var Builder
     */
    protected $builder;

    public function agendaCalendarId($value)
    {
            $agendaCalendar = \NextDeveloper\Agenda\Database\Models\Calendars::where('uuid', $value)->first();

        if($agendaCalendar) {
            return $this->builder->where('agenda_calendar_id', '=', $agendaCalendar->id);
        }
    }

    public function iamUserId($value)
    {
            $iamUser = \NextDeveloper\IAM\Database\Models\Users::where('uuid', $value)->first();

        if($iamUser) {
            return $this->builder->where('iam_user_id', '=', $iamUser->id);
        }
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}