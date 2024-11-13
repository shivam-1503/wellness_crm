<?php

namespace App\Http\Controllers\Api;

use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\LeadComment;
use App\Models\LeadStage;
use App\Models\CustomerSource;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Validator;

use DB;

     

class LeadsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_new_leads(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'phone' => 'required',
        ],
        [
            'name.required' => 'Name is required.',
            'phone.required' => 'Phone number is required.',
        ]);

        $id = auth('api')->user()->id;

        $lead = new Lead;
        $lead->title = $request->title;
        $lead->stage_id_fk = $request->stage_id_fk;
        $lead->company_id = $request->company_id;
        $lead->source_id_fk = $request->source_id_fk;
        $lead->source_type = $request->source_type;
        $lead->category = $request->category;
        $lead->est_amount = $request->est_amount;
        $lead->service_id = $request->service_id;
        $lead->name = $request->name;
        $lead->company = $request->company;
        $lead->phone = $request->phone;
        $lead->email = $request->email;
        $lead->state_id = $request->state_id;
        $lead->city = $request->city;
        $lead->address = $request->address;
        $lead->pincode = $request->pincode;
        $lead->gst = $request->gst;
        $lead->description = $request->description;
        $lead->remarks = $request->remarks;
        $lead->created_by = $id;
        $lead->save();

        return $this->sendResponse($lead, 'Lead Data Entered Successfully.');
    }

    public function leads_list()
    {
         // Fetch all leads from the database
         $lead = Lead::select('id', 'stage_id_fk', 'first_name', 'email', 'phone', 'priority','created_at')->get();
        
         // Return the leads as a JSON response
         return $this->sendResponse($lead, 'Lead Data Found Successfully.');
    }

    
    public function lead_stages()
    {
        $lead = LeadStage::select('id', 'name')->get();
        
         // Return the leads as a JSON response
         return $this->sendResponse($lead, 'Lead Stages Found Successfully.');
    }

    public function lead_sources()
    {
        $lead = CustomerSource::select('id', 'name')->get();
        
         // Return the leads as a JSON response
         return $this->sendResponse($lead, 'Lead Sources Found Successfully.');
    }

    public function get_services()
    {
        $lead = Service::select('id', 'title')->get();
        
         // Return the leads as a JSON response
         return $this->sendResponse($lead, 'Lead Services Found Successfully.');
    }
/*
    public function lead_detail(request $request, $id)
    {
        $lead = Lead::leftJoin('lead_activities', 'leads.id', '=', 'lead_activities.lead_id_fk')
        ->leftJoin('lead_comments', 'lead_comments.lead_id_fk', '=', 'leads.id')
        ->select('leads.id', 'leads.first_name', 'leads.phone', 'leads.email', 'lead_activities.task','lead_comments.description','lead_comments.date', 'lead_activities.due_date', 'lead_activities.status')
        ->find($id);   

        if($lead){
            return response()->json([
                'success' => true,
                'data'=> $lead
            ], 200);
        }
        else{
            return response()->json([
                'success' => false,
                'message'=> 'The Lead requested does not Exist'
            ], 404);
        } 
    }
  */
    
    public function lead_details($id)
    {
        $lead = Lead::select('id', 'first_name', 'phone', 'email', 'city', 'address', 'created_at')
                    ->where('id', $id)
                    ->get()->first();
        

        if(!$lead){
            return $this->sendError(false, 'Lead Not Found!');
        }
        else{

            $lead_activities = LeadActivity::select('id', 'task', 'due_date', 'status')
                    ->where('lead_id_fk', $id)
                    ->get();

            $lead_comments = LeadComment::select('id', 'description', 'date')
                    ->where('lead_id_fk', $id)
                    ->get();

            $lead->activities = $lead_activities;
            $lead->comments = $lead_comments;

            return $this->sendResponse($lead, 'Lead Data Found Successfully.');
        } 
    }



    public function get_project_list()
    {
        return 0;
    }

    public function assign_lead(lead $lead)
    {
        if(!$lead){
            return $this->errorResponse('No Lead Found on this Lead ID');
        }
        $lead = Lead::wherecolumn('id', 'assigned_to')->get();
        
        return response()->json([
            'success' => true,
            'data' => $lead
        ], 200);
    }

    public function store_call(request $request)
    {
        $this->validate($request,[
            'lead_id_fk' => 'required',
            'date' => 'required',
            'time' => 'required',
        ],
        [
            'lead_id_fk.required' => 'Lead is required.',
            'date.required' => 'Date is required.',
            'time.required' => 'Time is required.',
        ]);

        $id = auth('api')->user()->id;
        
        $lead = new LeadComment();
        $lead->lead_id_fk = $request->lead_id_fk;
        $lead->date = $request->date;
        $lead->time = $request->time;
        $lead->description = $request->description;
        $lead->priority = $request->priority;
        $lead->new_stage = 1;
        $lead->created_by = $id;
        $lead->save();

        return $this->sendResponse($lead, 'Call Data Found Successfully.');
    }

    public function store_waiting(request $request)
    {
        $this->validate($request,[
            'lead_id_fk' => 'required',
            'next_date' => 'required',
        ],
        [
            'lead_id_fk.required' => 'Lead is required.',
            'next_date.required' => 'Next date is required.',
        ]);

        $id = auth('api')->user()->id;

        $lead = new LeadComment();
        $lead->lead_id_fk = $request->lead_id_fk;
        $lead->next_date = $request->next_date;
        $lead->description = $request->description;
        $lead->priority = $request->priority;
        $lead->new_stage = 1;
        $lead->created_by = $id;
        $lead->save();

        return response()->json([
            'success' => true,
            'data' => $lead
        ], 200);
    }

    public function store_meeting(request $request)
    {
        $this->validate($request,[
            'lead_id_fk' => 'required',
            'act_time' => 'required',
            'act_slot' => 'required',
        ],
        [
            'lead_id_fk.required' => 'Lead is required.',
            'act_time.required' => 'Activity Time  is required.',
            'act_slot.required' => 'Activity Slot is required.',
        ]);

        $id = auth('api')->user()->id;

        $lead = new LeadActivity();
        $lead->lead_id_fk = $request->lead_id_fk;
        $lead->act_time = $request->act_time;
        $lead->user_id = $request->user_id;
        $lead->act_slot = $request->act_slot;
        $lead->location = $request->location;
        $lead->description = $request->description;
        $lead->priority = $request->priority;
        $lead->status = 1;
        $lead->created_by = $id;
        $lead->save();

        return response()->json([
            'success' => true,
            'data' => $lead
        ], 200);
    }

    public function store_comment(request $request)
    {
        $this->validate($request,[
            'lead_id_fk' => 'required',
            'comment' => 'required',
            'new_stage' => 'required',
        ],
        [
            'lead_id_fk.required' => 'Lead is required.',
            'comment.required' => 'Comment is required.',
            'new_stage.required' => 'Stage is required.',
        ]);

        $id = auth('api')->user()->id;

        $lead = new LeadComment();
        $lead->lead_id_fk = $request->lead_id_fk;
        $lead->comment = $request->comment;
        $lead->new_stage = $request->new_stage;
        $lead->priority = $request->priority;
        $lead->created_by = $id;
        $lead->save();

        return response()->json([
            'success' => true,
            'data' => $lead
        ], 200);
    }

    public function get_comments()
    {

        $lead = LeadComment::select('comment','new_stage','priority')->get();

        if($lead){
            return response()->json([
                'success' => true,
                'data' => $lead
            ], 200);
        }

        else{
            return response()->json([
                'success' => false,
                'message' => 'No comments found'
            ], 404);
        }
    }

    public function store_task_response(Request $request, $id)
    {
        
    }

    public function get_lead_communication()
    {
        return response()->json(['message' => '! Please edit here !']);
    }

}