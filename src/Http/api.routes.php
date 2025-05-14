<?php

Route::prefix('agenda')->group(
    function () {
        Route::prefix('calendars')->group(
            function () {
                Route::get('/', 'Calendars\CalendarsController@index');
                Route::get('/actions', 'Calendars\CalendarsController@getActions');

                Route::get('{agenda_calendars}/tags ', 'Calendars\CalendarsController@tags');
                Route::post('{agenda_calendars}/tags ', 'Calendars\CalendarsController@saveTags');
                Route::get('{agenda_calendars}/addresses ', 'Calendars\CalendarsController@addresses');
                Route::post('{agenda_calendars}/addresses ', 'Calendars\CalendarsController@saveAddresses');

                Route::get('/{agenda_calendars}/{subObjects}', 'Calendars\CalendarsController@relatedObjects');
                Route::get('/{agenda_calendars}', 'Calendars\CalendarsController@show');

                Route::post('/', 'Calendars\CalendarsController@store');
                Route::post('/{agenda_calendars}/do/{action}', 'Calendars\CalendarsController@doAction');

                Route::patch('/{agenda_calendars}', 'Calendars\CalendarsController@update');
                Route::delete('/{agenda_calendars}', 'Calendars\CalendarsController@destroy');
            }
        );

        Route::prefix('calendar-subscriptions')->group(
            function () {
                Route::get('/', 'CalendarSubscriptions\CalendarSubscriptionsController@index');
                Route::get('/actions', 'CalendarSubscriptions\CalendarSubscriptionsController@getActions');

                Route::get('{agenda_calendar_subscriptions}/tags ', 'CalendarSubscriptions\CalendarSubscriptionsController@tags');
                Route::post('{agenda_calendar_subscriptions}/tags ', 'CalendarSubscriptions\CalendarSubscriptionsController@saveTags');
                Route::get('{agenda_calendar_subscriptions}/addresses ', 'CalendarSubscriptions\CalendarSubscriptionsController@addresses');
                Route::post('{agenda_calendar_subscriptions}/addresses ', 'CalendarSubscriptions\CalendarSubscriptionsController@saveAddresses');

                Route::get('/{agenda_calendar_subscriptions}/{subObjects}', 'CalendarSubscriptions\CalendarSubscriptionsController@relatedObjects');
                Route::get('/{agenda_calendar_subscriptions}', 'CalendarSubscriptions\CalendarSubscriptionsController@show');

                Route::post('/', 'CalendarSubscriptions\CalendarSubscriptionsController@store');
                Route::post('/{agenda_calendar_subscriptions}/do/{action}', 'CalendarSubscriptions\CalendarSubscriptionsController@doAction');

                Route::patch('/{agenda_calendar_subscriptions}', 'CalendarSubscriptions\CalendarSubscriptionsController@update');
                Route::delete('/{agenda_calendar_subscriptions}', 'CalendarSubscriptions\CalendarSubscriptionsController@destroy');
            }
        );

        Route::prefix('address-books')->group(
            function () {
                Route::get('/', 'AddressBooks\AddressBooksController@index');
                Route::get('/actions', 'AddressBooks\AddressBooksController@getActions');

                Route::get('{agenda_address_books}/tags ', 'AddressBooks\AddressBooksController@tags');
                Route::post('{agenda_address_books}/tags ', 'AddressBooks\AddressBooksController@saveTags');
                Route::get('{agenda_address_books}/addresses ', 'AddressBooks\AddressBooksController@addresses');
                Route::post('{agenda_address_books}/addresses ', 'AddressBooks\AddressBooksController@saveAddresses');

                Route::get('/{agenda_address_books}/{subObjects}', 'AddressBooks\AddressBooksController@relatedObjects');
                Route::get('/{agenda_address_books}', 'AddressBooks\AddressBooksController@show');

                Route::post('/', 'AddressBooks\AddressBooksController@store');
                Route::post('/{agenda_address_books}/do/{action}', 'AddressBooks\AddressBooksController@doAction');

                Route::patch('/{agenda_address_books}', 'AddressBooks\AddressBooksController@update');
                Route::delete('/{agenda_address_books}', 'AddressBooks\AddressBooksController@destroy');
            }
        );

        Route::prefix('calendar-events')->group(
            function () {
                Route::get('/', 'CalendarEvents\CalendarEventsController@index');
                Route::get('/actions', 'CalendarEvents\CalendarEventsController@getActions');

                Route::get('{agenda_calendar_events}/tags ', 'CalendarEvents\CalendarEventsController@tags');
                Route::post('{agenda_calendar_events}/tags ', 'CalendarEvents\CalendarEventsController@saveTags');
                Route::get('{agenda_calendar_events}/addresses ', 'CalendarEvents\CalendarEventsController@addresses');
                Route::post('{agenda_calendar_events}/addresses ', 'CalendarEvents\CalendarEventsController@saveAddresses');

                Route::get('/{agenda_calendar_events}/{subObjects}', 'CalendarEvents\CalendarEventsController@relatedObjects');
                Route::get('/{agenda_calendar_events}', 'CalendarEvents\CalendarEventsController@show');

                Route::post('/', 'CalendarEvents\CalendarEventsController@store');
                Route::post('/{agenda_calendar_events}/do/{action}', 'CalendarEvents\CalendarEventsController@doAction');

                Route::patch('/{agenda_calendar_events}', 'CalendarEvents\CalendarEventsController@update');
                Route::delete('/{agenda_calendar_events}', 'CalendarEvents\CalendarEventsController@destroy');
            }
        );

        Route::prefix('calendar-event-attendees')->group(
            function () {
                Route::get('/', 'CalendarEventAttendees\CalendarEventAttendeesController@index');
                Route::get('/actions', 'CalendarEventAttendees\CalendarEventAttendeesController@getActions');

                Route::get('{agenda_calendar_event_attendees}/tags ', 'CalendarEventAttendees\CalendarEventAttendeesController@tags');
                Route::post('{agenda_calendar_event_attendees}/tags ', 'CalendarEventAttendees\CalendarEventAttendeesController@saveTags');
                Route::get('{agenda_calendar_event_attendees}/addresses ', 'CalendarEventAttendees\CalendarEventAttendeesController@addresses');
                Route::post('{agenda_calendar_event_attendees}/addresses ', 'CalendarEventAttendees\CalendarEventAttendeesController@saveAddresses');

                Route::get('/{agenda_calendar_event_attendees}/{subObjects}', 'CalendarEventAttendees\CalendarEventAttendeesController@relatedObjects');
                Route::get('/{agenda_calendar_event_attendees}', 'CalendarEventAttendees\CalendarEventAttendeesController@show');

                Route::post('/', 'CalendarEventAttendees\CalendarEventAttendeesController@store');
                Route::post('/{agenda_calendar_event_attendees}/do/{action}', 'CalendarEventAttendees\CalendarEventAttendeesController@doAction');

                Route::patch('/{agenda_calendar_event_attendees}', 'CalendarEventAttendees\CalendarEventAttendeesController@update');
                Route::delete('/{agenda_calendar_event_attendees}', 'CalendarEventAttendees\CalendarEventAttendeesController@destroy');
            }
        );

        Route::prefix('contacts')->group(
            function () {
                Route::get('/', 'Contacts\ContactsController@index');
                Route::get('/actions', 'Contacts\ContactsController@getActions');

                Route::get('{agenda_contacts}/tags ', 'Contacts\ContactsController@tags');
                Route::post('{agenda_contacts}/tags ', 'Contacts\ContactsController@saveTags');
                Route::get('{agenda_contacts}/addresses ', 'Contacts\ContactsController@addresses');
                Route::post('{agenda_contacts}/addresses ', 'Contacts\ContactsController@saveAddresses');

                Route::get('/{agenda_contacts}/{subObjects}', 'Contacts\ContactsController@relatedObjects');
                Route::get('/{agenda_contacts}', 'Contacts\ContactsController@show');

                Route::post('/', 'Contacts\ContactsController@store');
                Route::post('/{agenda_contacts}/do/{action}', 'Contacts\ContactsController@doAction');

                Route::patch('/{agenda_contacts}', 'Contacts\ContactsController@update');
                Route::delete('/{agenda_contacts}', 'Contacts\ContactsController@destroy');
            }
        );

        Route::prefix('tasks')->group(
            function () {
                Route::get('/', 'Tasks\TasksController@index');
                Route::get('/actions', 'Tasks\TasksController@getActions');

                Route::get('{agenda_tasks}/tags ', 'Tasks\TasksController@tags');
                Route::post('{agenda_tasks}/tags ', 'Tasks\TasksController@saveTags');
                Route::get('{agenda_tasks}/addresses ', 'Tasks\TasksController@addresses');
                Route::post('{agenda_tasks}/addresses ', 'Tasks\TasksController@saveAddresses');

                Route::get('/{agenda_tasks}/{subObjects}', 'Tasks\TasksController@relatedObjects');
                Route::get('/{agenda_tasks}', 'Tasks\TasksController@show');

                Route::post('/', 'Tasks\TasksController@store');
                Route::post('/{agenda_tasks}/do/{action}', 'Tasks\TasksController@doAction');

                Route::patch('/{agenda_tasks}', 'Tasks\TasksController@update');
                Route::delete('/{agenda_tasks}', 'Tasks\TasksController@destroy');
            }
        );

        Route::prefix('task-items')->group(
            function () {
                Route::get('/', 'TaskItems\TaskItemsController@index');
                Route::get('/actions', 'TaskItems\TaskItemsController@getActions');

                Route::get('{agenda_task_items}/tags ', 'TaskItems\TaskItemsController@tags');
                Route::post('{agenda_task_items}/tags ', 'TaskItems\TaskItemsController@saveTags');
                Route::get('{agenda_task_items}/addresses ', 'TaskItems\TaskItemsController@addresses');
                Route::post('{agenda_task_items}/addresses ', 'TaskItems\TaskItemsController@saveAddresses');

                Route::get('/{agenda_task_items}/{subObjects}', 'TaskItems\TaskItemsController@relatedObjects');
                Route::get('/{agenda_task_items}', 'TaskItems\TaskItemsController@show');

                Route::post('/', 'TaskItems\TaskItemsController@store');
                Route::post('/{agenda_task_items}/do/{action}', 'TaskItems\TaskItemsController@doAction');

                Route::patch('/{agenda_task_items}', 'TaskItems\TaskItemsController@update');
                Route::delete('/{agenda_task_items}', 'TaskItems\TaskItemsController@destroy');
            }
        );

        Route::prefix('task-assignees')->group(
            function () {
                Route::get('/', 'TaskAssignees\TaskAssigneesController@index');
                Route::get('/actions', 'TaskAssignees\TaskAssigneesController@getActions');

                Route::get('{agenda_task_assignees}/tags ', 'TaskAssignees\TaskAssigneesController@tags');
                Route::post('{agenda_task_assignees}/tags ', 'TaskAssignees\TaskAssigneesController@saveTags');
                Route::get('{agenda_task_assignees}/addresses ', 'TaskAssignees\TaskAssigneesController@addresses');
                Route::post('{agenda_task_assignees}/addresses ', 'TaskAssignees\TaskAssigneesController@saveAddresses');

                Route::get('/{agenda_task_assignees}/{subObjects}', 'TaskAssignees\TaskAssigneesController@relatedObjects');
                Route::get('/{agenda_task_assignees}', 'TaskAssignees\TaskAssigneesController@show');

                Route::post('/', 'TaskAssignees\TaskAssigneesController@store');
                Route::post('/{agenda_task_assignees}/do/{action}', 'TaskAssignees\TaskAssigneesController@doAction');

                Route::patch('/{agenda_task_assignees}', 'TaskAssignees\TaskAssigneesController@update');
                Route::delete('/{agenda_task_assignees}', 'TaskAssignees\TaskAssigneesController@destroy');
            }
        );

        Route::prefix('all-contacts')->group(
            function () {
                Route::get('/', 'AllContacts\AllContactsController@index');
                Route::get('/actions', 'AllContacts\AllContactsController@getActions');

                Route::get('{agenda_all_contacts}/tags ', 'AllContacts\AllContactsController@tags');
                Route::post('{agenda_all_contacts}/tags ', 'AllContacts\AllContactsController@saveTags');
                Route::get('{agenda_all_contacts}/addresses ', 'AllContacts\AllContactsController@addresses');
                Route::post('{agenda_all_contacts}/addresses ', 'AllContacts\AllContactsController@saveAddresses');

                Route::get('/{agenda_all_contacts}/{subObjects}', 'AllContacts\AllContactsController@relatedObjects');
                Route::get('/{agenda_all_contacts}', 'AllContacts\AllContactsController@show');

                Route::post('/', 'AllContacts\AllContactsController@store');
                Route::post('/{agenda_all_contacts}/do/{action}', 'AllContacts\AllContactsController@doAction');

                Route::patch('/{agenda_all_contacts}', 'AllContacts\AllContactsController@update');
                Route::delete('/{agenda_all_contacts}', 'AllContacts\AllContactsController@destroy');
            }
        );

        // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE





















    }
);



