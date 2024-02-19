<?php

namespace NextDeveloper\Agenda\Http\Controllers\Calendars;

use Illuminate\Http\Request;
use NextDeveloper\Agenda\Http\Controllers\AbstractController;
use NextDeveloper\Commons\Http\Response\ResponsableFactory;
use NextDeveloper\Agenda\Http\Requests\Calendars\CalendarsUpdateRequest;
use NextDeveloper\Agenda\Database\Filters\CalendarsQueryFilter;
use NextDeveloper\Agenda\Database\Models\Calendars;
use NextDeveloper\Agenda\Services\CalendarsService;
use NextDeveloper\Agenda\Http\Requests\Calendars\CalendarsCreateRequest;
use NextDeveloper\Commons\Http\Traits\Tags;use NextDeveloper\Commons\Http\Traits\Addresses;
class CalendarsController extends AbstractController
{
    private $model = Calendars::class;

    use Tags;
    use Addresses;
    /**
     * This method returns the list of calendars.
     *
     * optional http params:
     * - paginate: If you set paginate parameter, the result will be returned paginated.
     *
     * @param  CalendarsQueryFilter $filter  An object that builds search query
     * @param  Request              $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CalendarsQueryFilter $filter, Request $request)
    {
        $data = CalendarsService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
     * This method receives ID for the related model and returns the item to the client.
     *
     * @param  $calendarsId
     * @return mixed|null
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function show($ref)
    {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = CalendarsService::getByRef($ref);

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
        $objects = CalendarsService::relatedObjects($ref, $subObject);

        return ResponsableFactory::makeResponse($this, $objects);
    }

    /**
     * This method created Calendars object on database.
     *
     * @param  CalendarsCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function store(CalendarsCreateRequest $request)
    {
        $model = CalendarsService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates Calendars object on database.
     *
     * @param  $calendarsId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function update($calendarsId, CalendarsUpdateRequest $request)
    {
        $model = CalendarsService::update($calendarsId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates Calendars object on database.
     *
     * @param  $calendarsId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function destroy($calendarsId)
    {
        $model = CalendarsService::delete($calendarsId);

        return $this->noContent();
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
