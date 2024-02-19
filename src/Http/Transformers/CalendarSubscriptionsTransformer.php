<?php

namespace NextDeveloper\Agenda\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Agenda\Database\Models\CalendarSubscriptions;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\Agenda\Http\Transformers\AbstractTransformers\AbstractCalendarSubscriptionsTransformer;

/**
 * Class CalendarSubscriptionsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class CalendarSubscriptionsTransformer extends AbstractCalendarSubscriptionsTransformer
{

    /**
     * @param CalendarSubscriptions $model
     *
     * @return array
     */
    public function transform(CalendarSubscriptions $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('CalendarSubscriptions', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('CalendarSubscriptions', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
