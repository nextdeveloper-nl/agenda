<?php

namespace NextDeveloper\Agenda\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Agenda\Database\Models\CalendarItems;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\Agenda\Http\Transformers\AbstractTransformers\AbstractCalendarItemsTransformer;

/**
 * Class CalendarItemsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class CalendarItemsTransformer extends AbstractCalendarItemsTransformer
{

    /**
     * @param CalendarItems $model
     *
     * @return array
     */
    public function transform(CalendarItems $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('CalendarItems', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('CalendarItems', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
