<?php

namespace NextDeveloper\Agenda\Http\Transformers\AbstractTransformers;

use NextDeveloper\Agenda\Database\Models\AllContacts;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class AllContactsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class AbstractAllContactsTransformer extends AbstractTransformer
{

    /**
     * @param AllContacts $model
     *
     * @return array
     */
    public function transform(AllContacts $model)
    {
                        $iamUserId = \NextDeveloper\IAM\Database\Models\Users::where('id', $model->iam_user_id)->first();
        
        return $this->buildPayload(
            [
            'id'  =>  $model->id,
            'fullname'  =>  $model->fullname,
            'email'  =>  $model->email,
            'iam_user_id'  =>  $iamUserId ? $iamUserId->uuid : null,
            ]
        );
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
