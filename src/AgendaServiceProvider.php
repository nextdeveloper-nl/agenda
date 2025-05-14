<?php

namespace NextDeveloper\Agenda;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;
use NextDeveloper\Agenda\Console\Commands\FetchCalendarsCommand;
use NextDeveloper\Agenda\Console\Commands\FetchCalendarEventsCommand;
use NextDeveloper\Commons\AbstractServiceProvider;

/**
 * Class StayServiceProvider
 *
 * @package NextDeveloper\Agenda
 */
class AgendaServiceProvider extends AbstractServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * @throws \Exception
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
            __DIR__.'/../config/agenda.php' => config_path('agenda.php'),
            ], 'config',
        );

        $this->loadViewsFrom($this->dir.'/../resources/views', 'Agenda');

        //        $this->bootErrorHandler();
        $this->bootChannelRoutes();
        $this->bootModelBindings();
        $this->bootEvents();
        $this->bootLogger();
        $this->bootSchedule();
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->registerHelpers();
        $this->registerMiddlewares('agenda');
        $this->registerRoutes();
        $this->registerCommands();

        $this->mergeConfigFrom(__DIR__.'/../config/agenda.php', 'agenda');
        $this->customMergeConfigFrom(__DIR__.'/../config/relation.php', 'relation');
    }

    /**
     * @return void
     */
    public function bootLogger()
    {
        //        $monolog = Log::getMonolog();
        //        $monolog->pushProcessor(new \Monolog\Processor\WebProcessor());
        //        $monolog->pushProcessor(new \Monolog\Processor\MemoryUsageProcessor());
        //        $monolog->pushProcessor(new \Monolog\Processor\MemoryPeakUsageProcessor());
    }

    /**
     * @return array
     */
    public function provides()
    {
        return ['agenda'];
    }

    //    public function bootErrorHandler() {
    //        $this->app->singleton(
    //            ExceptionHandler::class,
    //            Handler::class
    //        );
    //    }

    /**
     * @return void
     */
    private function bootChannelRoutes()
    {
        if (file_exists(($file = $this->dir.'/../config/channel.routes.php'))) {
            include_once $file;
        }
    }

    /**
     * @return void
     */
    protected function bootEvents()
    {
        $configs = config()->all();

        foreach ($configs as $key => $value) {
            if (config()->has($key.'.events')) {
                foreach (config($key.'.events') as $event => $handlers) {
                    foreach ($handlers as $handler) {
                        $this->app['events']->listen($event, $handler);
                    }
                }
            }
        }
    }

    /**
     * Register module routes
     *
     * @return void
     */
    protected function registerRoutes()
    {
        if ( ! $this->app->routesAreCached() && config('leo.allowed_routes.agenda', true) ) {
            $this->app['router']
                ->namespace('NextDeveloper\Agenda\Http\Controllers')
                ->group(__DIR__.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'api.routes.php');
        }
    }

    /**
     * Registers module based commands
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                [
                    FetchCalendarsCommand::class,
                    FetchCalendarEventsCommand::class,
                ],
            );
        }
    }

    /**
     * This is here, in case of shit happens!
     *
     * @return void
     */
    private function checkDatabaseConnection()
    {
        $isSuccessfull = false;

        try {
            \DB::connection()->getPdo();

            $isSuccessfull = true;
        } catch (\Exception $e) {
            die('Could not connect to the database. Please check your configuration. error:'.$e);
        }

        return $isSuccessfull;
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    protected function bootSchedule(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $schedule->command('agenda:fetch-calendars')
                ->cron(config('agenda.schedule.cron'))
                ->when(config('agenda.schedule.enabled'));

            $schedule->command('agenda:fetch-calendar-events')
                ->cron(config('agenda.schedule.cron'))
                ->when(config('agenda.schedule.enabled'));

        });
    }
}
