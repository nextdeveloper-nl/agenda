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

    public static function get(?AddressBooksQueryFilter $filter = null, array $params = []) : \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
    {
        $user = UserHelper::me();

        $addressBooks = AddressBooks::filter($filter)
            ->where('iam_account_id', UserHelper::currentAccount()->id)
            ->paginate();

        if($addressBooks->count() === 0) {
            // Fix: create through the Service (not the Model directly). The model insert had no iam_user_id /
            // iam_account_id, so Postgres raised a NOT NULL violation and GET /agenda/address-books returned 500 for
            // any account without an address book yet. The service fills both from the current user and account.
            self::create([
                'name'  =>  I18n::t('Global Address Book ')
            ]);

            $addressBooks = AddressBooks::filter($filter)
                ->where('iam_account_id', UserHelper::currentAccount()->id)
                ->paginate();
        }

        return $addressBooks;
    }
}
