<?php

namespace NextDeveloper\Agenda\Database\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\Agenda\Database\Observers\TaskItemsObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Taggable;

/**
 * TaskItems model.
 *
 * @package  NextDeveloper\Agenda\Database\Models
 * @property integer $id
 * @property string $uuid
 * @property integer $agenda_task_id
 * @property string $google_id
 * @property string $title
 * @property string $notes
 * @property string $status
 * @property \Carbon\Carbon $due
 * @property \Carbon\Carbon $completed_at
 * @property integer $priority
 * @property integer $position
 * @property integer $iam_user_id
 * @property integer $iam_account_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class TaskItems extends Model
{
    use Filterable, CleanCache, Taggable;
    use UuidId;
    use SoftDeletes;


    public $timestamps = true;




    protected $table = 'agenda_task_items';


    /**
     @var array
     */
    protected $guarded = [];

    protected $fillable = [
            'agenda_task_id',
            'google_id',
            'title',
            'notes',
            'status',
            'due',
            'completed_at',
            'priority',
            'position',
            'iam_user_id',
            'iam_account_id',
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
    'agenda_task_id' => 'integer',
    'google_id' => 'string',
    'title' => 'string',
    'notes' => 'string',
    'status' => 'string',
    'due' => 'datetime',
    'completed_at' => 'datetime',
    'priority' => 'integer',
    'position' => 'integer',
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
    'due',
    'completed_at',
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
        parent::observe(TaskItemsObserver::class);

        self::registerScopes();
    }

    public static function registerScopes()
    {
        $globalScopes = config('agenda.scopes.global');
        $modelScopes = config('agenda.scopes.agenda_task_items');

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
