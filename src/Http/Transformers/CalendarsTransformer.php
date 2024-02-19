<?php

namespace NextDeveloper\Agenda\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Agenda\Database\Models\Calendars;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\Agenda\Http\Transformers\AbstractTransformers\AbstractCalendarsTransformer;

/**
 * Class CalendarsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class CalendarsTransformer extends AbstractCalendarsTransformer
{

    /**
     * @param Calendars $model
     *
     * @return array
     */
    public function transform(Calendars $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('Calendars', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('Calendars', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
