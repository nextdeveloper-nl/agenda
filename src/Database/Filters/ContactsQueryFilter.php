<?php

namespace NextDeveloper\Agenda\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;
            

/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class ContactsQueryFilter extends AbstractQueryFilter
{

    /**
     * @var Builder
     */
    protected $builder;
    
    public function name($value)
    {
        return $this->builder->where('name', 'like', '%' . $value . '%');
    }
    
    public function surname($value)
    {
        return $this->builder->where('surname', 'like', '%' . $value . '%');
    }
    
    public function email($value)
    {
        return $this->builder->where('email', 'like', '%' . $value . '%');
    }
    
    public function homePhone($value)
    {
        return $this->builder->where('home_phone', 'like', '%' . $value . '%');
    }
    
    public function cellPhone($value)
    {
        return $this->builder->where('cell_phone', 'like', '%' . $value . '%');
    }
    
    public function faxNumber($value)
    {
        return $this->builder->where('fax_number', 'like', '%' . $value . '%');
    }
    
    public function emailWork($value)
    {
        return $this->builder->where('email_work', 'like', '%' . $value . '%');
    }
    
    public function website($value)
    {
        return $this->builder->where('website', 'like', '%' . $value . '%');
    }
    
    public function notes($value)
    {
        return $this->builder->where('notes', 'like', '%' . $value . '%');
    }
    
    public function description($value)
    {
        return $this->builder->where('description', 'like', '%' . $value . '%');
    }

    public function createdAtStart($date)
    {
        return $this->builder->where('created_at', '>=', $date);
    }

    public function createdAtEnd($date)
    {
        return $this->builder->where('created_at', '<=', $date);
    }

    public function updatedAtStart($date)
    {
        return $this->builder->where('updated_at', '>=', $date);
    }

    public function updatedAtEnd($date)
    {
        return $this->builder->where('updated_at', '<=', $date);
    }

    public function deletedAtStart($date)
    {
        return $this->builder->where('deleted_at', '>=', $date);
    }

    public function deletedAtEnd($date)
    {
        return $this->builder->where('deleted_at', '<=', $date);
    }

    public function agendaAddressBookId($value)
    {
            $agendaAddressBook = \NextDeveloper\Agenda\Database\Models\AddressBooks::where('uuid', $value)->first();

        if($agendaAddressBook) {
            return $this->builder->where('agenda_address_book_id', '=', $agendaAddressBook->id);
        }
    }

    public function iamAccountId($value)
    {
            $iamAccount = \NextDeveloper\IAM\Database\Models\Accounts::where('uuid', $value)->first();

        if($iamAccount) {
            return $this->builder->where('iam_account_id', '=', $iamAccount->id);
        }
    }

    public function iamUserId($value)
    {
            $iamUser = \NextDeveloper\IAM\Database\Models\Users::where('uuid', $value)->first();

        if($iamUser) {
            return $this->builder->where('iam_user_id', '=', $iamUser->id);
        }
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
