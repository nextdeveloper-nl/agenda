<?php

namespace NextDeveloper\Agenda\Database\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\Agenda\Database\Observers\CalendarEventsObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Taggable;

/**
 * CalendarEvents model.
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
 * @property string $timezone
 * @property boolean $is_all_day
 * @property string $status
 * @property string $meeting_link
 * @property $data
 * @property string $external_event_id
 * @property string $rrule
 * @property  $rrule_options
 * @property string $cron_expression
 * @property string $yearly_notification_cron
 * @property string $frequency
 * @property string $frequency_variant
 * @property integer $repeat_interval
 * @property integer $occurrence_count
 * @property boolean $is_infinite
 * @property boolean $is_repeat
 */
class CalendarEvents extends Model
{
    use Filterable, CleanCache, Taggable;
    use UuidId;
    use SoftDeletes;


    public $timestamps = true;

    protected $table = 'agenda_calendar_events';


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
            'timezone',
            'is_all_day',
            'status',
            'meeting_link',
            'data',
            'external_event_id',
            'rrule',
            'rrule_options',
            'cron_expression',
            'yearly_notification_cron',
            'frequency',
            'frequency_variant',
            'repeat_interval',
            'occurrence_count',
            'is_infinite',
            'is_repeat',
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
    'guests' => \NextDeveloper\Commons\Database\Casts\IntegerArray::class,
    'starts_at' => 'datetime',
    'ends_at' => 'datetime',
    'agenda_calendar_id' => 'integer',
    'is_out_of_office' => 'boolean',
    'is_appointment_slot' => 'boolean',
    'tags' => \NextDeveloper\Commons\Database\Casts\TextArray::class,
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'deleted_at' => 'datetime',
    'timezone' => 'string',
    'is_all_day' => 'boolean',
    'status' => 'string',
    'meeting_link' => 'string',
    'data' => 'array',
    'external_event_id' => 'string',
    'rrule' => 'string',
    'rrule_options' => 'array',
    'cron_expression' => 'string',
    'yearly_notification_cron' => 'string',
    'frequency' => 'string',
    'frequency_variant' => 'string',
    'repeat_interval' => 'integer',
    'occurrence_count' => 'integer',
    'is_infinite' => 'boolean',
    'is_repeat' => 'boolean',
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

        self::registerScopes();
    }

    /**
     * Registers the observer once the model has finished booting.
     *
     * Registering it inside boot() instantiates the model while it is still booting,
     * which Laravel 12+ rejects with a LogicException.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();

        //  We create and add Observer even if we wont use it.
        static::observe(CalendarEventsObserver::class);
    }

    public static function registerScopes()
    {
        $globalScopes = config('agenda.scopes.global');
        $modelScopes = config('agenda.scopes.agenda_calendar_events');

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
