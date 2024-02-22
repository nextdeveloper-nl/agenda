<?php

namespace NextDeveloper\Agenda\Services;

use NextDeveloper\Agenda\Database\Filters\AddressBooksQueryFilter;
use NextDeveloper\Agenda\Database\Models\AddressBooks;
use NextDeveloper\Agenda\Services\AbstractServices\AbstractAddressBooksService;
use NextDeveloper\I18n\Helpers\i18n;
use NextDeveloper\IAM\Helpers\UserHelper;

/**
 * This class is responsible from managing the data for AddressBooks
 *
 * Class AddressBooksService.
 *
 * @package NextDeveloper\Agenda\Database\Models
 */
class AddressBooksService extends AbstractAddressBooksService
{

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    public static function get(AddressBooksQueryFilter $filter = null, array $params = []) : \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
    {
        $user = UserHelper::me();

        $addressBooks = AddressBooks::filter($filter)
            ->where('iam_account_id', UserHelper::currentAccount()->id)
            ->paginate();

        if($addressBooks->count() === 0) {
            AddressBooks::create([
                'name'  =>  I18n::t('Global Address Book ')
            ]);

            $addressBooks = AddressBooks::filter($filter)
                ->where('iam_account_id', UserHelper::currentAccount()->id)
                ->paginate();
        }

        return $addressBooks;
    }
}
