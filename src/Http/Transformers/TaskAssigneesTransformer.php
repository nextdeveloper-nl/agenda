<?php

namespace NextDeveloper\Agenda\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Agenda\Database\Models\TaskAssignees;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\Agenda\Http\Transformers\AbstractTransformers\AbstractTaskAssigneesTransformer;

/**
 * Class TaskAssigneesTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class TaskAssigneesTransformer extends AbstractTaskAssigneesTransformer
{

    /**
     * @param TaskAssignees $model
     *
     * @return array
     */
    public function transform(TaskAssignees $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('TaskAssignees', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('TaskAssignees', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
