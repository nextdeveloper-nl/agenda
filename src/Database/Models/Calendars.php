<?php

namespace NextDeveloper\Agenda\Database\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\Agenda\Database\Observers\CalendarsObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Taggable;

/**
 * Calendars model.
 *
 * @package  NextDeveloper\Agenda\Database\Models
 * @property integer $id
 * @property string $uuid
 * @property string $name
 * @property string $description
 * @property integer $iam_account_id
 * @property integer $iam_user_id
 * @property integer $object_id
 * @property string $object_type
 * @property string $timezone
 * @property boolean $is_public
 * @property array $tags
 * @property string $color
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $calendar_key
 * @property string $source
 * @property boolean $sync_enabled
 * @property string $last_sync_status
 * @property \Carbon\Carbon $last_sync_at
 * @property \Carbon\Carbon $sync_start_date
 */
class Calendars extends Model
{
    use Filterable, CleanCache, Taggable;
    use UuidId;
    use SoftDeletes;


    public $timestamps = true;

    protected $table = 'agenda_calendars';


    /**
     @var array
     */
    protected $guarded = [];

    protected $fillable = [
            'name',
            'description',
            'iam_account_id',
            'iam_user_id',
            'object_id',
            'object_type',
            'timezone',
            'is_public',
            'tags',
            'color',
            'calendar_key',
            'source',
            'sync_enabled',
            'last_sync_status',
            'last_sync_at',
            'sync_start_date',
    ];

    /**
      Here we have the fulltext fields. We can use these for fulltext search if enabled.
     */
    protected $fullTextFields = [

    ];

    /**
     @var array
     */
    protected $appends = [

    ];

    /**
     We are casting fields to objects so that we can work on them better
     *
     @var array
     */
    protected $casts = [
    'id' => 'integer',
    'name' => 'string',
    'description' => 'string',
    'object_id' => 'integer',
    'object_type' => 'string',
    'timezone' => 'string',
    'is_public' => 'boolean',
    'tags' => \NextDeveloper\Commons\Database\Casts\TextArray::class,
    'color' => 'string',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'deleted_at' => 'datetime',
    'calendar_key' => 'string',
    'source' => 'string',
    'sync_enabled' => 'boolean',
    'last_sync_status' => 'string',
    'last_sync_at' => 'datetime',
    'sync_start_date' => 'datetime',
    ];

    /**
     We are casting data fields.
     *
     @var array
     */
    protected $dates = [
    'created_at',
    'updated_at',
    'deleted_at',
    'last_sync_at',
    'sync_start_date',
    ];

    /**
     @var array
     */
    protected $with = [

    ];

    /**
     @var int
     */
    protected $perPage = 20;

    /**
     @return void
     */
    public static function boot()
    {
        parent::boot();

        //  We create and add Observer even if we wont use it.
        parent::observe(CalendarsObserver::class);

        self::registerScopes();
    }

    public static function registerScopes()
    {
        $globalScopes = config('agenda.scopes.global');
        $modelScopes = config('agenda.scopes.agenda_calendars');

        if(!$modelScopes) { $modelScopes = [];
        }
        if (!$globalScopes) { $globalScopes = [];
        }

        $scopes = array_merge(
            $globalScopes,
            $modelScopes
        );

        if($scopes) {
            foreach ($scopes as $scope) {
                static::addGlobalScope(app($scope));
            }
        }
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE






}
