<?php

namespace NextDeveloper\Agenda\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Agenda\Database\Models\Contacts;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\Agenda\Http\Transformers\AbstractTransformers\AbstractContactsTransformer;

/**
 * Class ContactsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class ContactsTransformer extends AbstractContactsTransformer
{

    /**
     * @param Contacts $model
     *
     * @return array
     */
    public function transform(Contacts $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('Contacts', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('Contacts', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
