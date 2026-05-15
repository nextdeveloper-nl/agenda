# NextDeveloper Agenda

A Laravel library for managing calendars, contacts, tasks, and scheduling. It provides a complete personal productivity backend — calendars with event attendees, task lists with assignees, address books, and external calendar subscriptions — all scoped to IAM accounts and users.

## Features

- [x] Calendar management — create and manage multiple calendars per account
- [x] Calendar events — full event lifecycle with attendee tracking
- [x] Calendar subscriptions — subscribe to external calendars (iCal/WebCal)
- [x] Calendar items — generic items within a calendar context
- [x] Contact management — store and organise contacts in address books
- [x] Address books — group contacts into named books
- [x] All-contacts view — unified contact list across all address books
- [x] Task management — create tasks with due dates and priorities
- [x] Task items — subtasks and checklist items within a task
- [x] Task assignees — assign tasks to one or more users
- [ ] Recurring event rules (iCal RRULE support)
- [ ] CalDAV sync
- [ ] Push notifications for upcoming events

## Core Models

| Model | Description |
|---|---|
| `Calendars` | User or account-owned calendar container |
| `CalendarEvents` | Events within a calendar |
| `CalendarEventAttendees` | Attendees linked to a calendar event |
| `CalendarItems` | Generic items attached to a calendar |
| `CalendarSubscriptions` | External calendar feed subscriptions |
| `AddressBooks` | Named contact collections |
| `Contacts` | Individual contact records |
| `AllContacts` | Read-only view across all address books |
| `Tasks` | Task records with status and priority |
| `TaskItems` | Subtasks or checklist entries within a task |
| `TaskAssignees` | User assignments on a task |

## Installation

```bash
composer require nextdeveloper/agenda
```

Register the service provider in `config/app.php` if not using auto-discovery:

```php
NextDeveloper\Agenda\AgendaServiceProvider::class,
```

## Commercial Support

Please let us know if you need any commercial support. We will be happy to help you on your project and/or applying this library in your project.

support@plusclouds.com

---

## Our Libraries

This library is part of the **NextDeveloper / PlusClouds open-source ecosystem**. Browse all available libraries and find the right building blocks for your next project:

[https://plusclouds.com/us/solutions/libraries](https://plusclouds.com/us/solutions/libraries)

---

## Join the Community

We believe great software is built together. The PlusClouds developer community is a place where engineers share ideas, ask questions, showcase what they have built, and help shape the direction of these libraries. Whether you are integrating a single package or building an entire platform on top of our stack, you are very welcome here.

Come and join us — we would love to see what you build:

[https://plusclouds.com/us/community](https://plusclouds.com/us/community)
