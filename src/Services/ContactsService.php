<?php

namespace NextDeveloper\Agenda\Services;

use NextDeveloper\Agenda\Database\Filters\ContactsQueryFilter;
use NextDeveloper\Agenda\Database\Models\Contacts;
use NextDeveloper\Agenda\Services\AbstractServices\AbstractContactsService;
use NextDeveloper\IAM\Helpers\UserHelper;

/**
 * This class is responsible from managing the data for Contacts
 *
 * Class ContactsService.
 *
 * @package NextDeveloper\Agenda\Database\Models
 */
class ContactsService extends AbstractContactsService
{

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
    public static function get(ContactsQueryFilter $filter = null, array $params = []) : \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
    {
        $user = UserHelper::me();

        $contacts = Contacts::filter($filter)
            ->where('iam_account_id', UserHelper::currentAccount()->id)
            ->paginate();

        return $contacts;
    }
}
