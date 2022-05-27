<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventDateController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'event_id' => 'required']);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $events = Event::find($input['event_id']);
        $events = $events->eventDates;

        return $this->sendResponse($events->toArray(), 'Products retrieved successfully.');
    }
}
