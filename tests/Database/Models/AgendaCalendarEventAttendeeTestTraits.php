<?php

namespace NextDeveloper\Agenda\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\Agenda\Database\Filters\AgendaCalendarEventAttendeeQueryFilter;
use NextDeveloper\Agenda\Services\AbstractServices\AbstractAgendaCalendarEventAttendeeService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait AgendaCalendarEventAttendeeTestTraits
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

    public function test_http_agendacalendareventattendee_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/agenda/agendacalendareventattendee',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_agendacalendareventattendee_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/agenda/agendacalendareventattendee', [
            'form_params'   =>  [
                'comment'  =>  'a',
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
    public function test_agendacalendareventattendee_model_get()
    {
        $result = AbstractAgendaCalendarEventAttendeeService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendacalendareventattendee_get_all()
    {
        $result = AbstractAgendaCalendarEventAttendeeService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendacalendareventattendee_get_paginated()
    {
        $result = AbstractAgendaCalendarEventAttendeeService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_agendacalendareventattendee_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendareventattendee_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendareventattendee_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEventAttendee\AgendaCalendarEventAttendeeRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendareventattendee_event_comment_filter()
    {
        try {
            $request = new Request(
                [
                'comment'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarEventAttendeeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendareventattendee_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventAttendeeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendareventattendee_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventAttendeeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendareventattendee_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventAttendeeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendareventattendee_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventAttendeeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendareventattendee_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventAttendeeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendareventattendee_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventAttendeeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendareventattendee_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventAttendeeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendareventattendee_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventAttendeeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendareventattendee_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventAttendeeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEventAttendee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}