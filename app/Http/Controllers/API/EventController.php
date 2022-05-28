<?php
namespace App\Http\Controllers\API;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class EventController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $events = Event::where('user_id',auth('sanctum')->user()->id)->get();

        return $this->sendResponse($events->toArray(), 'Events retrieved successfully.');
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
            'title' => 'required',
            'backgroundColor' => 'required',
            'borderColor' => 'required'
        ]);
        $input['user_id'] =auth('sanctum')->user()->id;
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        try {
            $event= new Event();
            $event->title = $input['title'];
            $event->backgroundColor = $input['backgroundColor'];
            $event->borderColor = $input['borderColor'];
            $event->user_id = $input['user_id'];
            $event->save();
        }catch (\Illuminate\Database\QueryException $ex){
            $this->sendError($ex, 'Event not saving', 422);
        }


        return $this->sendResponse($event->toArray(), 'Event created successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $event = Event::find($id);
        if (is_null($event)) {
            return $this->sendError('Event not found.');
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
    public function update(Request $request, Event $event)
    {
        $input = $request->all();

        $event->title = $input['title'] ?? $event->title ;
        $event->backgroundColor = $input['backgroundColor'] ?? $event->backgroundColor;
        $event->borderColor = $input['borderColor'] ?? $event->borderColor;
        $event->status = $input['status'] ?? $event->status;
        $event->save();
        return $this->sendResponse($event->toArray(), 'Event updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return $this->sendResponse($event->toArray(), 'Event deleted successfully.');
    }
}
