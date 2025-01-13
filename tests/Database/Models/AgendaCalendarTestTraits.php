<?php

namespace NextDeveloper\Agenda\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\Agenda\Database\Filters\AgendaCalendarQueryFilter;
use NextDeveloper\Agenda\Services\AbstractServices\AbstractAgendaCalendarService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait AgendaCalendarTestTraits
{
    public $http;

    /**
     *   Creating the Guzzle object
     */
    public function setupGuzzle()
    {
        $this->http = new Client(
            [
            'base_uri'  =>  '127.0.0.1:8000'
            ]
        );
    }

    /**
     *   Destroying the Guzzle object
     */
    public function destroyGuzzle()
    {
        $this->http = null;
    }

    public function test_http_agendacalendar_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/agenda/agendacalendar',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_agendacalendar_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/agenda/agendacalendar', [
            'form_params'   =>  [
                'name'  =>  'a',
                'description'  =>  'a',
                'object_type'  =>  'a',
                'timezone'  =>  'a',
                'color'  =>  'a',
                'calendar_key'  =>  'a',
                'source'  =>  'a',
                'last_sync_status'  =>  'a',
                                'last_sync_at'  =>  now(),
                ],
                ['http_errors' => false]
            ]
        );

        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
    }

    /**
     * Get test
     *
     * @return bool
     */
    public function test_agendacalendar_model_get()
    {
        $result = AbstractAgendaCalendarService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendacalendar_get_all()
    {
        $result = AbstractAgendaCalendarService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendacalendar_get_paginated()
    {
        $result = AbstractAgendaCalendarService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_agendacalendar_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendar_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendar\AgendaCalendarRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_name_filter()
    {
        try {
            $request = new Request(
                [
                'name'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_description_filter()
    {
        try {
            $request = new Request(
                [
                'description'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_object_type_filter()
    {
        try {
            $request = new Request(
                [
                'object_type'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_timezone_filter()
    {
        try {
            $request = new Request(
                [
                'timezone'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_color_filter()
    {
        try {
            $request = new Request(
                [
                'color'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_calendar_key_filter()
    {
        try {
            $request = new Request(
                [
                'calendar_key'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_source_filter()
    {
        try {
            $request = new Request(
                [
                'source'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_last_sync_status_filter()
    {
        try {
            $request = new Request(
                [
                'last_sync_status'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_last_sync_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'last_sync_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_last_sync_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'last_sync_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendar_event_last_sync_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'last_sync_atStart'  =>  now(),
                'last_sync_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendar::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}