<?php

namespace NextDeveloper\Agenda\Http\Controllers\CalendarSubscriptions;

use Illuminate\Http\Request;
use NextDeveloper\Agenda\Http\Controllers\AbstractController;
use NextDeveloper\Commons\Http\Response\ResponsableFactory;
use NextDeveloper\Agenda\Http\Requests\CalendarSubscriptions\CalendarSubscriptionsUpdateRequest;
use NextDeveloper\Agenda\Database\Filters\CalendarSubscriptionsQueryFilter;
use NextDeveloper\Agenda\Database\Models\CalendarSubscriptions;
use NextDeveloper\Agenda\Services\CalendarSubscriptionsService;
use NextDeveloper\Agenda\Http\Requests\CalendarSubscriptions\CalendarSubscriptionsCreateRequest;
use NextDeveloper\Commons\Http\Traits\Tags;use NextDeveloper\Commons\Http\Traits\Addresses;
class CalendarSubscriptionsController extends AbstractController
{
    private $model = CalendarSubscriptions::class;

    use Tags;
    use Addresses;
    /**
     * This method returns the list of calendarsubscriptions.
     *
     * optional http params:
     * - paginate: If you set paginate parameter, the result will be returned paginated.
     *
     * @param  CalendarSubscriptionsQueryFilter $filter  An object that builds search query
     * @param  Request                          $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CalendarSubscriptionsQueryFilter $filter, Request $request)
    {
        $data = CalendarSubscriptionsService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
     * This method receives ID for the related model and returns the item to the client.
     *
     * @param  $calendarSubscriptionsId
     * @return mixed|null
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function show($ref)
    {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = CalendarSubscriptionsService::getByRef($ref);

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
        $objects = CalendarSubscriptionsService::relatedObjects($ref, $subObject);

        return ResponsableFactory::makeResponse($this, $objects);
    }

    /**
     * This method created CalendarSubscriptions object on database.
     *
     * @param  CalendarSubscriptionsCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function store(CalendarSubscriptionsCreateRequest $request)
    {
        $model = CalendarSubscriptionsService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates CalendarSubscriptions object on database.
     *
     * @param  $calendarSubscriptionsId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function update($calendarSubscriptionsId, CalendarSubscriptionsUpdateRequest $request)
    {
        $model = CalendarSubscriptionsService::update($calendarSubscriptionsId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates CalendarSubscriptions object on database.
     *
     * @param  $calendarSubscriptionsId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function destroy($calendarSubscriptionsId)
    {
        $model = CalendarSubscriptionsService::delete($calendarSubscriptionsId);

        return $this->noContent();
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
