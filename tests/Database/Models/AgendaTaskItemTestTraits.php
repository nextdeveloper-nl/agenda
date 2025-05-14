<?php

namespace NextDeveloper\Agenda\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\Agenda\Database\Filters\AgendaTaskItemQueryFilter;
use NextDeveloper\Agenda\Services\AbstractServices\AbstractAgendaTaskItemService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait AgendaTaskItemTestTraits
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

    public function test_http_agendataskitem_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/agenda/agendataskitem',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_agendataskitem_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/agenda/agendataskitem', [
            'form_params'   =>  [
                'google_id'  =>  'a',
                'title'  =>  'a',
                'notes'  =>  'a',
                'status'  =>  'a',
                'priority'  =>  '1',
                'position'  =>  '1',
                    'due'  =>  now(),
                    'completed_at'  =>  now(),
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
    public function test_agendataskitem_model_get()
    {
        $result = AbstractAgendaTaskItemService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendataskitem_get_all()
    {
        $result = AbstractAgendaTaskItemService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendataskitem_get_paginated()
    {
        $result = AbstractAgendaTaskItemService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_agendataskitem_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendataskitem_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaTaskItem\AgendaTaskItemRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_google_id_filter()
    {
        try {
            $request = new Request(
                [
                'google_id'  =>  'a'
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_title_filter()
    {
        try {
            $request = new Request(
                [
                'title'  =>  'a'
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_notes_filter()
    {
        try {
            $request = new Request(
                [
                'notes'  =>  'a'
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_status_filter()
    {
        try {
            $request = new Request(
                [
                'status'  =>  'a'
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_priority_filter()
    {
        try {
            $request = new Request(
                [
                'priority'  =>  '1'
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_position_filter()
    {
        try {
            $request = new Request(
                [
                'position'  =>  '1'
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_due_filter_start()
    {
        try {
            $request = new Request(
                [
                'dueStart'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_completed_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'completed_atStart'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_due_filter_end()
    {
        try {
            $request = new Request(
                [
                'dueEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_completed_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'completed_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_due_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'dueStart'  =>  now(),
                'dueEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_completed_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'completed_atStart'  =>  now(),
                'completed_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendataskitem_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaTaskItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaTaskItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}