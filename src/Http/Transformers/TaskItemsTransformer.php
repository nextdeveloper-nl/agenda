<?php

namespace NextDeveloper\Agenda\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Agenda\Database\Models\TaskItems;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\Agenda\Http\Transformers\AbstractTransformers\AbstractTaskItemsTransformer;

/**
 * Class TaskItemsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class TaskItemsTransformer extends AbstractTaskItemsTransformer
{

    /**
     * @param TaskItems $model
     *
     * @return array
     */
    public function transform(TaskItems $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('TaskItems', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('TaskItems', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
