<?php

Route::prefix('agenda')->group(function () {
    Route::prefix('calendar-subscriptions')->group(
        function () {
            Route::get('/', 'CalendarSubscriptions\CalendarSubscriptionsController@index');

            Route::get('{agenda_calendar_subscriptions}/tags ', 'CalendarSubscriptions\CalendarSubscriptionsController@tags');
            Route::post('{agenda_calendar_subscriptions}/tags ', 'CalendarSubscriptions\CalendarSubscriptionsController@saveTags');
            Route::get('{agenda_calendar_subscriptions}/addresses ', 'CalendarSubscriptions\CalendarSubscriptionsController@addresses');
            Route::post('{agenda_calendar_subscriptions}/addresses ', 'CalendarSubscriptions\CalendarSubscriptionsController@saveAddresses');

            Route::get('/{agenda_calendar_subscriptions}/{subObjects}', 'CalendarSubscriptions\CalendarSubscriptionsController@relatedObjects');
            Route::get('/{agenda_calendar_subscriptions}', 'CalendarSubscriptions\CalendarSubscriptionsController@show');

            Route::post('/', 'CalendarSubscriptions\CalendarSubscriptionsController@store');
            Route::patch('/{agenda_calendar_subscriptions}', 'CalendarSubscriptions\CalendarSubscriptionsController@update');
            Route::delete('/{agenda_calendar_subscriptions}', 'CalendarSubscriptions\CalendarSubscriptionsController@destroy');
        }
    );

    Route::prefix('calendars')->group(
        function () {
            Route::get('/', 'Calendars\CalendarsController@index');

            Route::get('{agenda_calendars}/tags ', 'Calendars\CalendarsController@tags');
            Route::post('{agenda_calendars}/tags ', 'Calendars\CalendarsController@saveTags');
            Route::get('{agenda_calendars}/addresses ', 'Calendars\CalendarsController@addresses');
            Route::post('{agenda_calendars}/addresses ', 'Calendars\CalendarsController@saveAddresses');

            Route::get('/{agenda_calendars}/{subObjects}', 'Calendars\CalendarsController@relatedObjects');
            Route::get('/{agenda_calendars}', 'Calendars\CalendarsController@show');

            Route::post('/', 'Calendars\CalendarsController@store');
            Route::patch('/{agenda_calendars}', 'Calendars\CalendarsController@update');
            Route::delete('/{agenda_calendars}', 'Calendars\CalendarsController@destroy');
        }
    );

    Route::prefix('calendar-items')->group(
        function () {
            Route::get('/', 'CalendarItems\CalendarItemsController@index');

            Route::get('{agenda_calendar_items}/tags ', 'CalendarItems\CalendarItemsController@tags');
            Route::post('{agenda_calendar_items}/tags ', 'CalendarItems\CalendarItemsController@saveTags');
            Route::get('{agenda_calendar_items}/addresses ', 'CalendarItems\CalendarItemsController@addresses');
            Route::post('{agenda_calendar_items}/addresses ', 'CalendarItems\CalendarItemsController@saveAddresses');

            Route::get('/{agenda_calendar_items}/{subObjects}', 'CalendarItems\CalendarItemsController@relatedObjects');
            Route::get('/{agenda_calendar_items}', 'CalendarItems\CalendarItemsController@show');

            Route::post('/', 'CalendarItems\CalendarItemsController@store');
            Route::patch('/{agenda_calendar_items}', 'CalendarItems\CalendarItemsController@update');
            Route::delete('/{agenda_calendar_items}', 'CalendarItems\CalendarItemsController@destroy');
        }
    );

    Route::prefix('contacts')->group(
        function () {
            Route::get('/', 'Contacts\ContactsController@index');

            Route::get('{agenda_contacts}/tags ', 'Contacts\ContactsController@tags');
            Route::post('{agenda_contacts}/tags ', 'Contacts\ContactsController@saveTags');
            Route::get('{agenda_contacts}/addresses ', 'Contacts\ContactsController@addresses');
            Route::post('{agenda_contacts}/addresses ', 'Contacts\ContactsController@saveAddresses');

            Route::get('/{agenda_contacts}/{subObjects}', 'Contacts\ContactsController@relatedObjects');
            Route::get('/{agenda_contacts}', 'Contacts\ContactsController@show');

            Route::post('/', 'Contacts\ContactsController@store');
            Route::patch('/{agenda_contacts}', 'Contacts\ContactsController@update');
            Route::delete('/{agenda_contacts}', 'Contacts\ContactsController@destroy');
        }
    );

    Route::prefix('address-books')->group(
        function () {
            Route::get('/', 'AddressBooks\AddressBooksController@index');

            Route::get('{agenda_address_books}/tags ', 'AddressBooks\AddressBooksController@tags');
            Route::post('{agenda_address_books}/tags ', 'AddressBooks\AddressBooksController@saveTags');
            Route::get('{agenda_address_books}/addresses ', 'AddressBooks\AddressBooksController@addresses');
            Route::post('{agenda_address_books}/addresses ', 'AddressBooks\AddressBooksController@saveAddresses');

            Route::get('/{agenda_address_books}/{subObjects}', 'AddressBooks\AddressBooksController@relatedObjects');
            Route::get('/{agenda_address_books}', 'AddressBooks\AddressBooksController@show');

            Route::post('/', 'AddressBooks\AddressBooksController@store');
            Route::patch('/{agenda_address_books}', 'AddressBooks\AddressBooksController@update');
            Route::delete('/{agenda_address_books}', 'AddressBooks\AddressBooksController@destroy');
        }
    );

// EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

});
