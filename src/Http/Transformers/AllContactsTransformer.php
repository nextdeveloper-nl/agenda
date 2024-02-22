<?php

namespace NextDeveloper\Agenda\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Agenda\Database\Models\AllContacts;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\Agenda\Http\Transformers\AbstractTransformers\AbstractAllContactsTransformer;

/**
 * Class AllContactsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class AllContactsTransformer extends AbstractAllContactsTransformer
{

    /**
     * @param AllContacts $model
     *
     * @return array
     */
    public function transform(AllContacts $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('AllContacts', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('AllContacts', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
