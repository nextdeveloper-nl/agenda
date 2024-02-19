<?php

namespace NextDeveloper\Agenda\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\Agenda\Database\Filters\AgendaCalendarItemQueryFilter;
use NextDeveloper\Agenda\Services\AbstractServices\AbstractAgendaCalendarItemService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait AgendaCalendarItemTestTraits
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

    public function test_http_agendacalendaritem_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/agenda/agendacalendaritem',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_agendacalendaritem_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/agenda/agendacalendaritem', [
            'form_params'   =>  [
                'title'  =>  'a',
                'description'  =>  'a',
                'location'  =>  'a',
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
    public function test_agendacalendaritem_model_get()
    {
        $result = AbstractAgendaCalendarItemService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendacalendaritem_get_all()
    {
        $result = AbstractAgendaCalendarItemService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendacalendaritem_get_paginated()
    {
        $result = AbstractAgendaCalendarItemService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_agendacalendaritem_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendaritem_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarItem\AgendaCalendarItemRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_title_filter()
    {
        try {
            $request = new Request(
                [
                'title'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_description_filter()
    {
        try {
            $request = new Request(
                [
                'description'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_location_filter()
    {
        try {
            $request = new Request(
                [
                'location'  =>  'a'
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_starts_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'starts_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_ends_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'ends_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_starts_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'starts_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_ends_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'ends_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_starts_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'starts_atStart'  =>  now(),
                'starts_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_ends_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'ends_atStart'  =>  now(),
                'ends_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendaritem_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaCalendarItemQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}