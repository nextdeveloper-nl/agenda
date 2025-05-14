<?php

namespace NextDeveloper\Agenda\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\Agenda\Database\Filters\AgendaTaskAssigneeQueryFilter;
use NextDeveloper\Agenda\Services\AbstractServices\AbstractAgendaTaskAssigneeService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait AgendaTaskAssigneeTestTraits
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

    public function test_http_agendataskassignee_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/agenda/agendataskassignee',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_agendataskassignee_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/agenda/agendataskassignee', [
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
    public function test_agendataskassignee_model_get()
    {
        $result = AbstractAgendaTaskAssigneeService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendataskassignee_get_all()
    {
        $result = AbstractAgendaTaskAssigneeService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendataskassignee_get_paginated()
    {
        $result = AbstractAgendaTaskAssigneeService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_agendataskassignee_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskassignee_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskassignee_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskAssignee\AgendaTaskAssigneeRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskassignee_event_comment_filter()
    {
        try {
            $request = new Request(
                [
                'comment'  =>  'a'
                ]
            );

            $filter = new AgendaTaskAssigneeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskassignee_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new AgendaTaskAssigneeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskassignee_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new AgendaTaskAssigneeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskassignee_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new AgendaTaskAssigneeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskassignee_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskAssigneeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskassignee_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskAssigneeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskassignee_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskAssigneeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskassignee_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskAssigneeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskassignee_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskAssigneeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskassignee_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskAssigneeQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskAssignee::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}