<?php

return [
    'optionrequest' => function ($value) {
        return NextDeveloper\Options\Database\Models\OptionRequest::findByRef($value);
    },

'agendacalendarsubscription' => function ($value) {
        return NextDeveloper\Agenda\Database\Models\AgendaCalendarSubscription::findByRef($value);
},

'agendacalendar' => function ($value) {
        return NextDeveloper\Agenda\Database\Models\AgendaCalendar::findByRef($value);
},

'agendacalendaritem' => function ($value) {
        return NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::findByRef($value);
},

'agendacontact' => function ($value) {
        return NextDeveloper\Agenda\Database\Models\AgendaContact::findByRef($value);
},

'agendaaddressbook' => function ($value) {
        return NextDeveloper\Agenda\Database\Models\AgendaAddressBook::findByRef($value);
},

'agendacalendarsubscription' => function ($value) {
        return NextDeveloper\Agenda\Database\Models\AgendaCalendarSubscription::findByRef($value);
},

'agendacalendar' => function ($value) {
        return NextDeveloper\Agenda\Database\Models\AgendaCalendar::findByRef($value);
},

'agendacalendaritem' => function ($value) {
        return NextDeveloper\Agenda\Database\Models\AgendaCalendarItem::findByRef($value);
},

'agendacontact' => function ($value) {
        return NextDeveloper\Agenda\Database\Models\AgendaContact::findByRef($value);
},

'agendaaddressbook' => function ($value) {
        return NextDeveloper\Agenda\Database\Models\AgendaAddressBook::findByRef($value);
},

'agendaallcontact' => function ($value) {
        return NextDeveloper\Agenda\Database\Models\AgendaAllContact::findByRef($value);
},

// EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
];