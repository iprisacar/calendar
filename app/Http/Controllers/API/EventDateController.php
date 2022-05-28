<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventDate;
use Illuminate\Database\QueryException;
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
        $events = EventDate::get();

        return $this->sendResponse($events->toArray(), 'Events date retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'event_id' => 'required',
            'allDay' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        try {
            EventDate::create([
                'event_id'=>$input['event_id'],
                'allDay'=>$input['allDay'],
                'start'=>$input['start'],
                'end'=>$input['end']
            ]);
//            $event= new EventDate();
//            $event->event_id = $input['event_id'];
//            $event->allDay = $input['allDay'];
//            $event->start = $input['start'];
//            $event->end = $input['end'];
//            $event->save();
        }catch (\Illuminate\Database\QueryException $ex){
            $this->sendError($ex, 'Event date not saving', 422);
        }


        return $this->sendResponse($event->toArray(), 'Event date created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $event = EventDate::find($id);
        if (is_null($event)) {
            return $this->sendError('Event date not found.');
        }
        return $this->sendResponse($event->toArray(), 'Event retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, EventDate $eventDate)
    {
        $input = $request->all();

        $eventDate->allDay = $input['allDay'] ?? $eventDate->allDay ;
        $eventDate->start = $input['start'] ?? $eventDate->start;
        $eventDate->end = $input['end'] ?? $eventDate->end;
        $eventDate->save();
        return $this->sendResponse($eventDate->toArray(), 'Event date updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EventDate $eventDate)
    {
        $eventDate->delete();
        return $this->sendResponse($eventDate->toArray(), 'Event date deleted successfully.');
    }
}
