<?php

namespace NextDeveloper\Agenda\Database\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\Agenda\Database\Observers\CalendarItemsObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Taggable;
use Tpetry\PostgresqlEnhanced\Eloquent\Casts\IntegerArrayCast;
use Illuminate\Notifications\Notifiable;

/**
 * CalendarItems model.
 *
 * @package  NextDeveloper\Agenda\Database\Models
 * @property integer $id
 * @property string $uuid
 * @property string $title
 * @property string $description
 * @property string $location
 * @property array $guests
 * @property \Carbon\Carbon $starts_at
 * @property \Carbon\Carbon $ends_at
 * @property integer $iam_user_id
 * @property integer $iam_account_id
 * @property integer $agenda_calendar_id
 * @property boolean $is_out_of_office
 * @property boolean $is_appointment_slot
 * @property array $tags
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class CalendarItems extends Model
{
    use Filterable, UuidId, CleanCache, Taggable;
    use SoftDeletes;


    public $timestamps = true;

    protected $table = 'agenda_calendar_items';


    /**
     @var array
     */
    protected $guarded = [];

    protected $fillable = [
            'title',
            'description',
            'location',
            'guests',
            'starts_at',
            'ends_at',
            'iam_user_id',
            'iam_account_id',
            'agenda_calendar_id',
            'is_out_of_office',
            'is_appointment_slot',
            'tags',
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
    'title' => 'string',
    'description' => 'string',
    'location' => 'string',
    'guests' => 'array:integer',
    'starts_at' => 'datetime',
    'ends_at' => 'datetime',
    'agenda_calendar_id' => 'integer',
    'is_out_of_office' => 'boolean',
    'is_appointment_slot' => 'boolean',
    'tags' => \NextDeveloper\Commons\Database\Casts\TextArray::class,
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'deleted_at' => 'datetime',
    ];

    /**
     We are casting data fields.
     *
     @var array
     */
    protected $dates = [
    'starts_at',
    'ends_at',
    'created_at',
    'updated_at',
    'deleted_at',
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
        parent::observe(CalendarItemsObserver::class);

        self::registerScopes();
    }

    public static function registerScopes()
    {
        $globalScopes = config('agenda.scopes.global');
        $modelScopes = config('agenda.scopes.agenda_calendar_items');

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
