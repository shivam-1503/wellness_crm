<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Models\Task;

use DB;

class RestController extends BaseController
{
    public function get_tasks()
    {
        $task = Task::with(['user:name,id'])->whereNotNull('user_id')->select('id', 'title', 'user_id', 'type', 'start_date', 'end_date', 'lead_id', 'description', 'attendee', 'meeting_link', 'priority', 'status', 'response_status', 'response_remarks')->get();

        if($task){ 
            return $this->sendResponse($task, 'Here is the given task');
        }

        else{
            return $this->sendError(false);
        }
    }
    
    public function add_event(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required',
            'status' => 'required',
        ],
        [
            'title.required' => 'Title is required.',
            'start_date.required' => 'Starting Date  is required.',
            'end_date.required' => 'Ending Date is required.',
            'description.required' => 'Description is required.',
            'status.required' => 'Status is required.',
        ]);
        $id = auth('api')->user()->id;

        $event = new Task;
        $event->title = $request->title;
        $event->description = $request->description;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->type = $request->type;
        $event->lead_id = $request->lead_id;
        $event->priority = $request->priority;
        $event->response_status = $request->response_status;
        $event->response_remarks = $request->response_remarks;
        $event->status = $request->status;
        $event->created_by = $id;
        $event->save();

        return $this->sendResponse($event,'This is the newly added event.');
    }

    public function edit_event(Request $request, $id)
    {
        
        $event = Task::find($id);

        if (!$event) {
            return $this->sendError(false);
        }

        $data = $request->validate([
            'title' => 'required|varchar|max:255',
            'description' => 'required|text',
            'start_date' => 'required|datetime',
            'end_date' => 'required|datetime',
            'type' => 'required|int',
            'lead_id' => 'required|int',
            'priority' => 'required|varchar|max:20',
            'response_status' => 'required|int',
            'response_remarks' => 'required|text',
            'status' => 'required|int',
        ]);

        $event->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'type' => $data['type'],
            'lead_id' => $data['lead_id'],
            'priority' => $data['priority'],
            'response_status' => $data['response_status'],
            'response_remarks' => $data['response_remarks'],
            'status' => $data['status'],
            'updated_by' => $id,
        ]);

        return $this->sendResponse($event, 'Event updated successfully');        
    }

    public function delete_event(Request $request, $id)
    {
        {
            
            $event = Task::find($id);
    
            if (!$event)
            {
                return $this->sendError(false);
            }
    
            $event->delete();
    
            return $this->sendResponse('Event deleted successfully');
        }
    }
}