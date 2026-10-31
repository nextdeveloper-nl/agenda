<?php

namespace NextDeveloper\Agenda\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use NextDeveloper\Agenda\Database\Models\AddressBooks;
use NextDeveloper\Agenda\Database\Models\Contacts;
use NextDeveloper\Commons\Database\Models\ExternalServices;
use NextDeveloper\Commons\Helpers\GoogleWorkspaceHelper;
use NextDeveloper\IAM\Helpers\UserHelper;

/**
 * Read-only import of a connected Google account's contacts (People API people.connections.list)
 * into the user's own agenda contacts. Needs the contacts.readonly scope. Nothing is written back to Google.
 *
 * The contacts live in a per-user address book named "Google Contacts" (tagged source:google), so the Agenda
 * user role (account + user scope) only ever shows them to the user who connected the Google account.
 * Duplicates are skipped by email within the user's agenda contacts (from any address book).
 */
class GoogleContactsImportService
{
    public const ADDRESS_BOOK_NAME = 'Google Contacts';

    public const SOURCE_TAG = 'source:google';

    private const ENDPOINT = 'https://people.googleapis.com/v1/people/me/connections';

    private const PAGE_SIZE = 1000;

    /**
     * Imports contacts for one google_workspace ExternalServices row and records the result on its
     * configuration ('contacts_sync') so the panel can show last-synced status.
     *
     * @return array{status: string, imported: int, skipped: int, total: int, last_synced_at: string, error: ?string}
     */
    public static function import(ExternalServices $service): array
    {
        $result = ['status' => 'success', 'imported' => 0, 'skipped' => 0, 'total' => 0, 'error' => null];

        try {
            if (!GoogleWorkspaceHelper::hasScope($service, GoogleWorkspaceHelper::SCOPE_CONTACTS_READONLY)) {
                throw new \RuntimeException('contacts.readonly scope was not granted. Please reconnect your Google account.');
            }

            // Everything below is created as the connection owner, so the contacts belong to that user only.
            // The previous identity is restored in the finally block, and the switch is verified before writing.
            [$previousUserId, $previousAccountId] = self::currentIdentity();

            UserHelper::setUserById($service->iam_user_id);
            UserHelper::setCurrentAccountById($service->iam_account_id);

            if (UserHelper::me()?->id !== $service->iam_user_id || UserHelper::currentAccount()?->id !== $service->iam_account_id) {
                throw new \RuntimeException('Could not switch to the owner of the Google connection');
            }

            $token = GoogleWorkspaceHelper::freshAccessToken($service);

            if (!$token) {
                throw new \RuntimeException('Unable to refresh the Google token. Please reconnect your account.');
            }

            $addressBook = self::addressBookFor($service);
            $pageToken   = null;

            do {
                $response = Http::withToken($token)->get(self::ENDPOINT, array_filter([
                    'personFields' => 'names,emailAddresses',
                    'pageSize'     => self::PAGE_SIZE,
                    'pageToken'    => $pageToken,
                ]));

                if (!$response->successful()) {
                    // the status is the exception code so the catch below can tell an auth failure from a transient one
                    throw new \RuntimeException(
                        $response->json('error.message') ?? ('People API error ' . $response->status()),
                        $response->status()
                    );
                }

                foreach ($response->json('connections', []) as $person) {
                    self::importPerson($person, $service, $addressBook, $result);
                }

                $pageToken = $response->json('nextPageToken');
            } while ($pageToken);
        } catch (\Throwable $e) {
            $result['status'] = 'error';
            $result['error']  = $e->getMessage();

            // Google rejected the token (401) or access (403): flag the connection and email the owner once
            if (in_array($e->getCode(), [401, 403], true)) {
                GoogleWorkspaceHelper::flagUnauthorized($service, 'contacts');
            }

            Log::warning('[Agenda::GoogleContactsImportService] Import failed', [
                'external_service_uuid' => $service->uuid,
                'error'                 => $e->getMessage(),
            ]);
        }

        finally {
            $result['last_synced_at'] = now()->toISOString();

            // Recorded while still acting as the connection owner, then the previous identity is restored
            GoogleWorkspaceHelper::recordSync($service, 'contacts_sync', $result);

            if (isset($previousUserId) && $previousUserId) {
                UserHelper::setUserById($previousUserId);
            }

            if (isset($previousAccountId) && $previousAccountId) {
                UserHelper::setCurrentAccountById($previousAccountId);
            }
        }

        return $result;
    }

    /**
     * Id of the user and account the process currently acts as (null when none could be resolved, e.g. console).
     *
     * @return array{0: ?int, 1: ?int}
     */
    private static function currentIdentity(): array
    {
        try {
            return [UserHelper::me()?->id, UserHelper::currentAccount()?->id];
        } catch (\Throwable) {
            return [null, null];
        }
    }

    /**
     * The user's "Google Contacts" address book, created on first import.
     */
    private static function addressBookFor(ExternalServices $service): AddressBooks
    {
        // Owner, account and the source tag together identify the import address book (not the name alone)
        $addressBook = AddressBooks::withoutGlobalScopes()
            ->where('iam_user_id', $service->iam_user_id)
            ->where('iam_account_id', $service->iam_account_id)
            ->where('name', self::ADDRESS_BOOK_NAME)
            ->whereRaw('? = ANY(tags)', [self::SOURCE_TAG])
            ->first();

        if ($addressBook) {
            return $addressBook;
        }

        // Created through the service as the connection owner (set in import())
        return AddressBooksService::create([
            'name'        => self::ADDRESS_BOOK_NAME,
            'description' => 'Contacts imported from your Google account (read-only)',
            'tags'        => [self::SOURCE_TAG],
        ]);
    }

    /**
     * A person without an email address cannot be reached here, so it is not imported.
     */
    private static function importPerson(array $person, ExternalServices $service, AddressBooks $addressBook, array &$result): void
    {
        foreach ($person['emailAddresses'] ?? [] as $emailAddress) {
            $email = strtolower(trim($emailAddress['value'] ?? ''));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            $result['total']++;

            $exists = Contacts::withoutGlobalScopes()
                ->where('iam_user_id', $service->iam_user_id)
                ->where('iam_account_id', $service->iam_account_id)
                ->whereRaw('lower(email) = ?', [$email])
                ->exists();

            if ($exists) {
                $result['skipped']++;
                continue;
            }

            $name = $person['names'][0] ?? [];

            ContactsService::create([
                'name'                   => $name['givenName'] ?? ($name['displayName'] ?? $email),
                'surname'                => $name['familyName'] ?? null,
                'email'                  => $email,
                'agenda_address_book_id' => $addressBook->id,
            ]);

            $result['imported']++;
        }
    }
}
