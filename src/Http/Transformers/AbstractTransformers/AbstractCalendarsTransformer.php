<?php

namespace NextDeveloper\Agenda\Http\Transformers\AbstractTransformers;

use NextDeveloper\Agenda\Database\Models\Calendars;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class CalendarsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class AbstractCalendarsTransformer extends AbstractTransformer
{

    /**
     * @param Calendars $model
     *
     * @return array
     */
    public function transform(Calendars $model)
    {
                        $iamAccountId = \NextDeveloper\IAM\Database\Models\Accounts::where('id', $model->iam_account_id)->first();
                    $iamUserId = \NextDeveloper\IAM\Database\Models\Users::where('id', $model->iam_user_id)->first();
        
        return $this->buildPayload(
            [
            'id'  =>  $model->uuid,
            'name'  =>  $model->name,
            'description'  =>  $model->description,
            'iam_account_id'  =>  $iamAccountId ? $iamAccountId->uuid : null,
            'iam_user_id'  =>  $iamUserId ? $iamUserId->uuid : null,
            'object_id'  =>  $model->object_id,
            'object_type'  =>  $model->object_type,
            'timezone'  =>  $model->timezone,
            'is_public'  =>  $model->is_public,
            'tags'  =>  $model->tags,
            'color'  =>  $model->color,
            'created_at'  =>  $model->created_at,
            'updated_at'  =>  $model->updated_at,
            'deleted_at'  =>  $model->deleted_at,
            ]
        );
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
