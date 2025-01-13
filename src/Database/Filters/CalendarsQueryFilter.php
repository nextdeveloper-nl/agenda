<?php

namespace NextDeveloper\Agenda\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;
        

/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class CalendarsQueryFilter extends AbstractQueryFilter
{
    /**
     * Filter by tags
     *
     * @param  $values
     * @return Builder
     */
    public function tags($values)
    {
        $tags = explode(',', $values);

        $search = '';

        for($i = 0; $i < count($tags); $i++) {
            $search .= "'" . trim($tags[$i]) . "',";
        }

        $search = substr($search, 0, -1);

        return $this->builder->whereRaw('tags @> ARRAY[' . $search . ']');
    }

    /**
     * @var Builder
     */
    protected $builder;
    
    public function name($value)
    {
        return $this->builder->where('name', 'like', '%' . $value . '%');
    }
    
    public function description($value)
    {
        return $this->builder->where('description', 'like', '%' . $value . '%');
    }
    
    public function objectType($value)
    {
        return $this->builder->where('object_type', 'like', '%' . $value . '%');
    }
    
    public function timezone($value)
    {
        return $this->builder->where('timezone', 'like', '%' . $value . '%');
    }
    
    public function color($value)
    {
        return $this->builder->where('color', 'like', '%' . $value . '%');
    }
    
    public function calendarKey($value)
    {
        return $this->builder->where('calendar_key', 'like', '%' . $value . '%');
    }
    
    public function source($value)
    {
        return $this->builder->where('source', 'like', '%' . $value . '%');
    }
    
    public function lastSyncStatus($value)
    {
        return $this->builder->where('last_sync_status', 'like', '%' . $value . '%');
    }

    public function isPublic($value)
    {
        if(!is_bool($value)) {
            $value = false;
        }

        return $this->builder->where('is_public', $value);
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

    public function lastSyncAtStart($date)
    {
        return $this->builder->where('last_sync_at', '>=', $date);
    }

    public function lastSyncAtEnd($date)
    {
        return $this->builder->where('last_sync_at', '<=', $date);
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
