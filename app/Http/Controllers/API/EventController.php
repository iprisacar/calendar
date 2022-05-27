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
        $responseData=[];
        foreach ($events as $event){
            $responseData['event'][]=[
                'title'=>$event->title,
                'backgroundColor'=>$event->backgroundColor,
                'borderColor' =>$event->borderColor,
                'status' =>$event->status,
            ];
           $eventDates= $event->eventDates;
            foreach ($eventDates as $eventDate){
                $responseData['events_dates'][]=[
                    'title'=>$event->title,
                    'backgroundColor'=>$event->backgroundColor,
                    'borderColor' =>$event->borderColor,
                    'status' =>$event->status,
                    'start' =>$eventDate->start??'',
                    'end' =>$eventDate->end??'',
                    'allDay' =>$eventDate->allDay??'',
                ];
            }
        }
        return $this->sendResponse($responseData, 'Events retrieved successfully.');
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
            return $this->sendError('Product not found.');
        }
        return $this->sendResponse($event->toArray(), 'Product retrieved successfully.');
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
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $event->name = $input['name'];
        $event->detail = $input['detail'];
        $event->save();
        return $this->sendResponse($event->toArray(), 'Product updated successfully.');
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
        return $this->sendResponse($event->toArray(), 'Product deleted successfully.');
    }
}
