<?php

namespace NextDeveloper\Agenda\Http\Requests\Contacts;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class ContactsUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string',
        'surname' => 'nullable|string',
        'email' => 'nullable|string',
        'home_phone' => 'nullable|string',
        'cell_phone' => 'nullable|string',
        'fax_number' => 'nullable|string',
        'email_work' => 'nullable|string',
        'website' => 'nullable|string',
        'notes' => 'nullable|string',
        'description' => 'nullable|string',
        'agenda_address_book_id' => 'nullable|exists:agenda_address_books,uuid|uuid',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}