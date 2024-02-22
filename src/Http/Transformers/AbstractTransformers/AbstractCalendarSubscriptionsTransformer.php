<?php

namespace NextDeveloper\Agenda\Http\Transformers\AbstractTransformers;

use NextDeveloper\Agenda\Database\Models\CalendarSubscriptions;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class CalendarSubscriptionsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class AbstractCalendarSubscriptionsTransformer extends AbstractTransformer
{

    /**
     * @param CalendarSubscriptions $model
     *
     * @return array
     */
    public function transform(CalendarSubscriptions $model)
    {
                        $agendaCalendarId = \NextDeveloper\Agenda\Database\Models\Calendars::where('id', $model->agenda_calendar_id)->first();
                    $iamUserId = \NextDeveloper\IAM\Database\Models\Users::where('id', $model->iam_user_id)->first();
        
        return $this->buildPayload(
            [
            'id'  =>  $model->id,
            'agenda_calendar_id'  =>  $agendaCalendarId ? $agendaCalendarId->uuid : null,
            'iam_user_id'  =>  $iamUserId ? $iamUserId->uuid : null,
            'can_write'  =>  $model->can_write,
            ]
        );
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE


}
