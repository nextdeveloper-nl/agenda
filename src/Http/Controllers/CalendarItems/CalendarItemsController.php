<?php

namespace NextDeveloper\Agenda\Http\Controllers\CalendarItems;

use Illuminate\Http\Request;
use NextDeveloper\Agenda\Http\Controllers\AbstractController;
use NextDeveloper\Commons\Http\Response\ResponsableFactory;
use NextDeveloper\Agenda\Http\Requests\CalendarItems\CalendarItemsUpdateRequest;
use NextDeveloper\Agenda\Database\Filters\CalendarItemsQueryFilter;
use NextDeveloper\Agenda\Database\Models\CalendarItems;
use NextDeveloper\Agenda\Services\CalendarItemsService;
use NextDeveloper\Agenda\Http\Requests\CalendarItems\CalendarItemsCreateRequest;
use NextDeveloper\Commons\Http\Traits\Tags;use NextDeveloper\Commons\Http\Traits\Addresses;
class CalendarItemsController extends AbstractController
{
    private $model = CalendarItems::class;

    use Tags;
    use Addresses;
    /**
     * This method returns the list of calendaritems.
     *
     * optional http params:
     * - paginate: If you set paginate parameter, the result will be returned paginated.
     *
     * @param  CalendarItemsQueryFilter $filter  An object that builds search query
     * @param  Request                  $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CalendarItemsQueryFilter $filter, Request $request)
    {
        $data = CalendarItemsService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
     * This method receives ID for the related model and returns the item to the client.
     *
     * @param  $calendarItemsId
     * @return mixed|null
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function show($ref)
    {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = CalendarItemsService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method returns the list of sub objects the related object. Sub object means an object which is preowned by
     * this object.
     *
     * It can be tags, addresses, states etc.
     *
     * @param  $ref
     * @param  $subObject
     * @return void
     */
    public function relatedObjects($ref, $subObject)
    {
        $objects = CalendarItemsService::relatedObjects($ref, $subObject);

        return ResponsableFactory::makeResponse($this, $objects);
    }

    /**
     * This method created CalendarItems object on database.
     *
     * @param  CalendarItemsCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function store(CalendarItemsCreateRequest $request)
    {
        $model = CalendarItemsService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates CalendarItems object on database.
     *
     * @param  $calendarItemsId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function update($calendarItemsId, CalendarItemsUpdateRequest $request)
    {
        $model = CalendarItemsService::update($calendarItemsId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates CalendarItems object on database.
     *
     * @param  $calendarItemsId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function destroy($calendarItemsId)
    {
        $model = CalendarItemsService::delete($calendarItemsId);

        return $this->noContent();
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
