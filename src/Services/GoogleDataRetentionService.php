<?php

namespace NextDeveloper\Agenda\Services;

use Illuminate\Support\Facades\Log;
use NextDeveloper\Agenda\Database\Models\AddressBooks;
use NextDeveloper\Agenda\Database\Models\CalendarEventAttendees;
use NextDeveloper\Agenda\Database\Models\CalendarEvents;
use NextDeveloper\Agenda\Database\Models\Calendars;
use NextDeveloper\Agenda\Database\Models\Contacts;

/**
 * Retention and deletion of data synced from Google (calendar events, attendees, imported contacts).
 *
 * Deletions here are hard deletes (forceDelete): the policy promises the data is gone, so soft-deleted rows would
 * not count. They are bulk queries on purpose (retention can touch thousands of rows); this is the one place where
 * models are written directly instead of through the Service classes. Only data of calendars with source 'Google'
 * and the user's "Google Contacts" address book is ever touched. Records created from a meeting in CRM
 * (accounts, users added to an account) live in other modules and are never touched.
 */
class GoogleDataRetentionService
{
    /**
     * Deletes synced Google events (and their attendees) that ended more than $months months ago.
     * Future events and events that are still running are never deleted.
     *
     * @return array{events: int, attendees: int}
     */
    public static function purgeExpiredEvents(int $months, bool $dryRun = false): array
    {
        $cutoff = now()->subMonths($months);

        $events = CalendarEvents::withoutGlobalScopes()
            ->whereIn('agenda_calendar_id', self::googleCalendarIds())
            ->where('ends_at', '<', $cutoff);

        return self::deleteEvents($events, $dryRun, 'retention');
    }

    /**
     * Deletes everything synced from Google for one user: all events with their attendees and, optionally, the
     * imported contacts (the "Google Contacts" address book and its contacts). With $accountId (the scheduled
     * purge after a disconnect) only the data of that account is deleted.
     *
     * @return array{events: int, attendees: int, contacts: int}
     */
    public static function purgeUser(int $userId, bool $includeContacts, bool $dryRun = false, ?int $accountId = null): array
    {
        $events = CalendarEvents::withoutGlobalScopes()
            ->whereIn('agenda_calendar_id', self::googleCalendarIds($userId, $accountId));

        $result = self::deleteEvents($events, $dryRun, 'user ' . $userId);

        $result['contacts'] = $includeContacts ? self::purgeContacts($userId, $dryRun, $accountId) : 0;

        Log::info('[Agenda::GoogleDataRetention] User data deleted', ['iam_user_id' => $userId, 'dry_run' => $dryRun] + $result);

        return $result;
    }

    /**
     * Deletes the user's imported Google contacts and the address book they live in.
     */
    private static function purgeContacts(int $userId, bool $dryRun, ?int $accountId = null): int
    {
        $bookIds = AddressBooks::withoutGlobalScopes()
            ->where('iam_user_id', $userId)
            ->when($accountId, fn ($query) => $query->where('iam_account_id', $accountId))
            ->where('name', GoogleContactsImportService::ADDRESS_BOOK_NAME)
            ->whereRaw('? = ANY(tags)', [GoogleContactsImportService::SOURCE_TAG])
            ->pluck('id');

        if ($bookIds->isEmpty()) {
            return 0;
        }

        $contacts = Contacts::withoutGlobalScopes()
            ->where('iam_user_id', $userId)
            ->when($accountId, fn ($query) => $query->where('iam_account_id', $accountId))
            ->whereIn('agenda_address_book_id', $bookIds);

        $count = (clone $contacts)->withTrashed()->count();

        if (!$dryRun) {
            $contacts->withTrashed()->forceDelete();
            AddressBooks::withoutGlobalScopes()->whereIn('id', $bookIds)->withTrashed()->forceDelete();
        }

        return $count;
    }

    /**
     * Ids of the Google calendars (of one user, or of everybody).
     */
    private static function googleCalendarIds(?int $userId = null, ?int $accountId = null)
    {
        $calendars = Calendars::withoutGlobalScopes()->withTrashed()->where('source', 'Google');

        if ($userId) {
            $calendars->where('iam_user_id', $userId);
        }

        if ($accountId) {
            $calendars->where('iam_account_id', $accountId);
        }

        return $calendars->select('id');
    }

    /**
     * Hard-deletes the matched events and their attendees in chunks.
     *
     * @return array{events: int, attendees: int}
     */
    private static function deleteEvents($events, bool $dryRun, string $context): array
    {
        $events = $events->withTrashed();
        $result = ['events' => 0, 'attendees' => 0];

        (clone $events)->select('id')->chunkById(500, function ($chunk) use (&$result, $dryRun) {
            $ids = $chunk->pluck('id');

            $attendees = CalendarEventAttendees::withoutGlobalScopes()->withTrashed()->whereIn('agenda_calendar_event_id', $ids);

            $result['attendees'] += (clone $attendees)->count();
            $result['events']    += $ids->count();

            if (!$dryRun) {
                $attendees->forceDelete();
                CalendarEvents::withoutGlobalScopes()->withTrashed()->whereIn('id', $ids)->forceDelete();
            }
        });

        if ($result['events'] > 0) {
            Log::info('[Agenda::GoogleDataRetention] Events deleted', ['context' => $context, 'dry_run' => $dryRun] + $result);
        }

        return $result;
    }
}
