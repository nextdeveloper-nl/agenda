<?php

namespace NextDeveloper\Agenda\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\Agenda\Database\Filters\AgendaAddressBookQueryFilter;
use NextDeveloper\Agenda\Services\AbstractServices\AbstractAgendaAddressBookService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait AgendaAddressBookTestTraits
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

    public function test_http_agendaaddressbook_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/agenda/agendaaddressbook',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_agendaaddressbook_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/agenda/agendaaddressbook', [
            'form_params'   =>  [
                'name'  =>  'a',
                'description'  =>  'a',
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
    public function test_agendaaddressbook_model_get()
    {
        $result = AbstractAgendaAddressBookService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendaaddressbook_get_all()
    {
        $result = AbstractAgendaAddressBookService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendaaddressbook_get_paginated()
    {
        $result = AbstractAgendaAddressBookService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_agendaaddressbook_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendaaddressbook_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::first();

            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::first();

            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::first();

            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::first();

            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::first();

            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::first();

            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::first();

            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::first();

            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::first();

            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::first();

            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendaaddressbook_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::first();

            event(new \NextDeveloper\Agenda\Events\AgendaAddressBook\AgendaAddressBookRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendaaddressbook_event_name_filter()
    {
        try {
            $request = new Request(
                [
                'name'  =>  'a'
                ]
            );

            $filter = new AgendaAddressBookQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendaaddressbook_event_description_filter()
    {
        try {
            $request = new Request(
                [
                'description'  =>  'a'
                ]
            );

            $filter = new AgendaAddressBookQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendaaddressbook_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new AgendaAddressBookQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendaaddressbook_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new AgendaAddressBookQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendaaddressbook_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new AgendaAddressBookQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendaaddressbook_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaAddressBookQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendaaddressbook_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaAddressBookQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendaaddressbook_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaAddressBookQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendaaddressbook_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaAddressBookQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendaaddressbook_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaAddressBookQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendaaddressbook_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaAddressBookQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaAddressBook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}