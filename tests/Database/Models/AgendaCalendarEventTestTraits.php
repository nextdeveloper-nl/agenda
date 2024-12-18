<?php

namespace NextDeveloper\Agenda\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\Agenda\Database\Filters\AgendaCalendarEventQueryFilter;
use NextDeveloper\Agenda\Services\AbstractServices\AbstractAgendaCalendarEventService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait AgendaCalendarEventTestTraits
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

    public function test_http_agendacalendarevent_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/agenda/agendacalendarevent',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_agendacalendarevent_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/agenda/agendacalendarevent', [
            'form_params'   =>  [
                'title'  =>  'a',
                'description'  =>  'a',
                'location'  =>  'a',
                'timezone'  =>  'a',
                'status'  =>  'a',
                'meeting_link'  =>  'a',
                'external_event_id'  =>  'a',
                    'starts_at'  =>  now(),
                    'ends_at'  =>  now(),
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
    public function test_agendacalendarevent_model_get()
    {
        $result = AbstractAgendaCalendarEventService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendacalendarevent_get_all()
    {
        $result = AbstractAgendaCalendarEventService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendacalendarevent_get_paginated()
    {
        $result = AbstractAgendaCalendarEventService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_agendacalendarevent_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarevent_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarEvent\AgendaCalendarEventRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_title_filter()
    {
        try {
            $request = new Request(
                [
                'title'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_description_filter()
    {
        try {
            $request = new Request(
                [
                'description'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_location_filter()
    {
        try {
            $request = new Request(
                [
                'location'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_timezone_filter()
    {
        try {
            $request = new Request(
                [
                'timezone'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_status_filter()
    {
        try {
            $request = new Request(
                [
                'status'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_meeting_link_filter()
    {
        try {
            $request = new Request(
                [
                'meeting_link'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_external_event_id_filter()
    {
        try {
            $request = new Request(
                [
                'external_event_id'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_starts_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'starts_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_ends_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'ends_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_starts_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'starts_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_ends_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'ends_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_starts_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'starts_atStart'  =>  now(),
                'starts_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_ends_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'ends_atStart'  =>  now(),
                'ends_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarevent_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarEventQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}