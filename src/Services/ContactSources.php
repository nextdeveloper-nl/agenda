<?php

namespace NextDeveloper\Agenda\Services;

use NextDeveloper\Agenda\Database\Models\AddressBooks;

/**
 * Import sources of Agenda contacts. Every source owns one address book per user + account, identified by its name
 * and a 'source:<key>' tag (the name alone is not enough). The contacts API reports the key as `source` and filters
 * on it (?source=microsoft).
 */
class ContactSources
{
    public const SOURCES = [
        'google' => [
            'name'        => GoogleContactsImportService::ADDRESS_BOOK_NAME,
            'tag'         => GoogleContactsImportService::SOURCE_TAG,
            'description' => 'Contacts imported from your Google account (read-only)',
        ],
        'microsoft' => [
            'name'        => 'Microsoft Contacts',
            'tag'         => 'source:microsoft',
            'description' => 'Contacts imported from your Microsoft 365 account (read-only)',
        ],
    ];

    public static function isKnown(?string $source): bool
    {
        return $source !== null && isset(self::SOURCES[strtolower($source)]);
    }

    /**
     * Ids of the address books that hold contacts of the given source.
     */
    public static function addressBookIds(string $source)
    {
        $definition = self::SOURCES[strtolower($source)];

        return AddressBooks::withoutGlobalScopes()
            ->where('name', $definition['name'])
            ->whereRaw('? = ANY(tags)', [$definition['tag']])
            ->select('id');
    }

    /**
     * Source key of an address book, null when it is not an import address book.
     */
    public static function sourceOf(?int $addressBookId): ?string
    {
        if (!$addressBookId) {
            return null;
        }

        foreach (array_keys(self::SOURCES) as $source) {
            if (self::addressBookIds($source)->where('id', $addressBookId)->exists()) {
                return $source;
            }
        }

        return null;
    }

    /**
     * The user's import address book for a source, created on first use. Created through the service, so the
     * caller must already act as the connection owner (user + account set).
     */
    public static function addressBookFor(string $source, int $userId, int $accountId): AddressBooks
    {
        $definition = self::SOURCES[strtolower($source)];

        $addressBook = AddressBooks::withoutGlobalScopes()
            ->where('iam_user_id', $userId)
            ->where('iam_account_id', $accountId)
            ->where('name', $definition['name'])
            ->whereRaw('? = ANY(tags)', [$definition['tag']])
            ->first();

        return $addressBook ?? AddressBooksService::create([
            'name'        => $definition['name'],
            'description' => $definition['description'],
            'tags'        => [$definition['tag']],
        ]);
    }
}
