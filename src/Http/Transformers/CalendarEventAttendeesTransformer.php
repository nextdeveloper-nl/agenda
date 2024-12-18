<?php

namespace NextDeveloper\Agenda\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Agenda\Database\Models\CalendarEventAttendees;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\Agenda\Http\Transformers\AbstractTransformers\AbstractCalendarEventAttendeesTransformer;

/**
 * Class CalendarEventAttendeesTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class CalendarEventAttendeesTransformer extends AbstractCalendarEventAttendeesTransformer
{

    /**
     * @param CalendarEventAttendees $model
     *
     * @return array
     */
    public function transform(CalendarEventAttendees $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('CalendarEventAttendees', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('CalendarEventAttendees', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
