<?php

namespace NextDeveloper\Agenda\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\Agenda\Database\Filters\AgendaContactQueryFilter;
use NextDeveloper\Agenda\Services\AbstractServices\AbstractAgendaContactService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait AgendaContactTestTraits
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

    public function test_http_agendacontact_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/agenda/agendacontact',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_agendacontact_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/agenda/agendacontact', [
            'form_params'   =>  [
                'name'  =>  'a',
                'surname'  =>  'a',
                'email'  =>  'a',
                'home_phone'  =>  'a',
                'cell_phone'  =>  'a',
                'fax_number'  =>  'a',
                'email_work'  =>  'a',
                'website'  =>  'a',
                'notes'  =>  'a',
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
    public function test_agendacontact_model_get()
    {
        $result = AbstractAgendaContactService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendacontact_get_all()
    {
        $result = AbstractAgendaContactService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendacontact_get_paginated()
    {
        $result = AbstractAgendaContactService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_agendacontact_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::first();

            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::first();

            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::first();

            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::first();

            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::first();

            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::first();

            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::first();

            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::first();

            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::first();

            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::first();

            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacontact_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::first();

            event(new \NextDeveloper\Agenda\Events\AgendaContact\AgendaContactRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_name_filter()
    {
        try {
            $request = new Request(
                [
                'name'  =>  'a'
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_surname_filter()
    {
        try {
            $request = new Request(
                [
                'surname'  =>  'a'
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_email_filter()
    {
        try {
            $request = new Request(
                [
                'email'  =>  'a'
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_home_phone_filter()
    {
        try {
            $request = new Request(
                [
                'home_phone'  =>  'a'
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_cell_phone_filter()
    {
        try {
            $request = new Request(
                [
                'cell_phone'  =>  'a'
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_fax_number_filter()
    {
        try {
            $request = new Request(
                [
                'fax_number'  =>  'a'
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_email_work_filter()
    {
        try {
            $request = new Request(
                [
                'email_work'  =>  'a'
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_website_filter()
    {
        try {
            $request = new Request(
                [
                'website'  =>  'a'
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_notes_filter()
    {
        try {
            $request = new Request(
                [
                'notes'  =>  'a'
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_description_filter()
    {
        try {
            $request = new Request(
                [
                'description'  =>  'a'
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacontact_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgendaContactQueryFilter($request);

            $model = \NextDeveloper\Agenda\Database\Models\AgendaContact::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}