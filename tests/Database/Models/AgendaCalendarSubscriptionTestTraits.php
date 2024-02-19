<?php

namespace NextDeveloper\Agenda\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\Agenda\Database\Filters\AgendaCalendarSubscriptionQueryFilter;
use NextDeveloper\Agenda\Services\AbstractServices\AbstractAgendaCalendarSubscriptionService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait AgendaCalendarSubscriptionTestTraits
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

    public function test_http_agendacalendarsubscription_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/agenda/agendacalendarsubscription',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_agendacalendarsubscription_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/agenda/agendacalendarsubscription', [
            'form_params'   =>  [
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
    public function test_agendacalendarsubscription_model_get()
    {
        $result = AbstractAgendaCalendarSubscriptionService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendacalendarsubscription_get_all()
    {
        $result = AbstractAgendaCalendarSubscriptionService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agendacalendarsubscription_get_paginated()
    {
        $result = AbstractAgendaCalendarSubscriptionService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_agendacalendarsubscription_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agendacalendarsubscription_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarSubscription::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarSubscription::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarSubscription::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarSubscription::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarSubscription::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarSubscription::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarSubscription::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarSubscription::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarSubscription::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarSubscription::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agendacalendarsubscription_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\Agenda\Database\Models\AgendaCalendarSubscription::first();

            event(new \NextDeveloper\Agenda\Events\AgendaCalendarSubscription\AgendaCalendarSubscriptionRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}