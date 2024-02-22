<?php

namespace NextDeveloper\Agenda\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Agenda\Database\Models\AddressBooks;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\Agenda\Http\Transformers\AbstractTransformers\AbstractAddressBooksTransformer;

/**
 * Class AddressBooksTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class AddressBooksTransformer extends AbstractAddressBooksTransformer
{

    /**
     * @param AddressBooks $model
     *
     * @return array
     */
    public function transform(AddressBooks $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('AddressBooks', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('AddressBooks', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
