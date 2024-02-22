<?php

namespace NextDeveloper\Agenda\Http\Transformers\AbstractTransformers;

use NextDeveloper\Agenda\Database\Models\Contacts;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class ContactsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agenda\Http\Transformers
 */
class AbstractContactsTransformer extends AbstractTransformer
{

    /**
     * @param Contacts $model
     *
     * @return array
     */
    public function transform(Contacts $model)
    {
                        $agendaAddressBookId = \NextDeveloper\Agenda\Database\Models\AddressBooks::where('id', $model->agenda_address_book_id)->first();
        
        return $this->buildPayload(
            [
            'id'  =>  $model->uuid,
            'name'  =>  $model->name,
            'surname'  =>  $model->surname,
            'email'  =>  $model->email,
            'home_phone'  =>  $model->home_phone,
            'cell_phone'  =>  $model->cell_phone,
            'fax_number'  =>  $model->fax_number,
            'email_work'  =>  $model->email_work,
            'website'  =>  $model->website,
            'notes'  =>  $model->notes,
            'description'  =>  $model->description,
            'agenda_address_book_id'  =>  $agendaAddressBookId ? $agendaAddressBookId->uuid : null,
            'created_at'  =>  $model->created_at,
            'updated_at'  =>  $model->updated_at,
            'deleted_at'  =>  $model->deleted_at,
            ]
        );
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
