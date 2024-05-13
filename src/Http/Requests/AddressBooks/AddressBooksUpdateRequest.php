<?php

namespace NextDeveloper\Agenda\Http\Requests\AddressBooks;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class AddressBooksUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string',
        'description' => 'nullable|string',
        'tags' => 'nullable',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}