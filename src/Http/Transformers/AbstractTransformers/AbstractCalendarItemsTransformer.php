<?php

namespace NextDeveloper\Agenda\Http\Transformers\AbstractTransformers;

use NextDeveloper\Agenda\Database\Models\CalendarItems;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class CalendarItemsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class AbstractCalendarItemsTransformer extends AbstractTransformer
{

    /**
     * @param CalendarItems $model
     *
     * @return array
     */
    public function transform(CalendarItems $model)
    {
                        $iamUserId = \NextDeveloper\IAM\Database\Models\Users::where('id', $model->iam_user_id)->first();
                    $iamAccountId = \NextDeveloper\IAM\Database\Models\Accounts::where('id', $model->iam_account_id)->first();
                    $agendaCalendarId = \NextDeveloper\Agenda\Database\Models\Calendars::where('id', $model->agenda_calendar_id)->first();
        
        return $this->buildPayload(
            [
            'id'  =>  $model->uuid,
            'title'  =>  $model->title,
            'description'  =>  $model->description,
            'location'  =>  $model->location,
            'guests'  =>  $model->guests,
            'starts_at'  =>  $model->starts_at,
            'ends_at'  =>  $model->ends_at,
            'iam_user_id'  =>  $iamUserId ? $iamUserId->uuid : null,
            'iam_account_id'  =>  $iamAccountId ? $iamAccountId->uuid : null,
            'agenda_calendar_id'  =>  $agendaCalendarId ? $agendaCalendarId->uuid : null,
            'is_out_of_office'  =>  $model->is_out_of_office,
            'is_appointment_slot'  =>  $model->is_appointment_slot,
            'tags'  =>  $model->tags,
            'created_at'  =>  $model->created_at,
            'updated_at'  =>  $model->updated_at,
            'deleted_at'  =>  $model->deleted_at,
            ]
        );
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
