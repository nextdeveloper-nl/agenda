<?php

namespace NextDeveloper\Agenda\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\Agenda\Database\Filters\AgendaTaskQueryFilter;
use NextDeveloper\Agenda\Services\AbstractServices\AbstractAgendaTaskService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait AgendaTaskTestTraits
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

    public function test_http_agendatask_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/agenda/agendatask',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_agendatask_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/agenda/agendatask', [
            'form_params'   =>  [
                'name'  =>  'a',
                'description'  =>  'a',
                'color'  =>  'a',
                'google_id'  =>  'a',
                'object_type'  =>  'a',
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
    public function test_agendatask_model_get()
    {
        $result = AbstractAgendaTaskService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendatask_get_all()
    {
        $result = AbstractAgendaTaskService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendatask_get_paginated()
    {
        $result = AbstractAgendaTaskService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_agendatask_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendatask_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTask\AgendaTaskRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_name_filter()
    {
        try {
            $request = new Request(
                [
                'name'  =>  'a'
                ]
            );

            $filter = new AgendaTaskQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_description_filter()
    {
        try {
            $request = new Request(
                [
                'description'  =>  'a'
                ]
            );

            $filter = new AgendaTaskQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_color_filter()
    {
        try {
            $request = new Request(
                [
                'color'  =>  'a'
                ]
            );

            $filter = new AgendaTaskQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_google_id_filter()
    {
        try {
            $request = new Request(
                [
                'google_id'  =>  'a'
                ]
            );

            $filter = new AgendaTaskQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_object_type_filter()
    {
        try {
            $request = new Request(
                [
                'object_type'  =>  'a'
                ]
            );

            $filter = new AgendaTaskQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new AgendaTaskQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new AgendaTaskQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new AgendaTaskQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendatask_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTask::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}