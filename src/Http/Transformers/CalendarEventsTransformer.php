<?php

namespace NextDeveloper\Agenda\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Agenda\Database\Models\CalendarEvents;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\Agenda\Http\Transformers\AbstractTransformers\AbstractCalendarEventsTransformer;

/**
 * Class CalendarEventsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class CalendarEventsTransformer extends AbstractCalendarEventsTransformer
{

    /**
     * @param CalendarEvents $model
     *
     * @return array
     */
    public function transform(CalendarEvents $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('CalendarEvents', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('CalendarEvents', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
