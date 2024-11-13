<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerSource;
use App\Models\Lead;
use App\Models\LeadStage;
use App\Models\LeadActivity;
use App\Models\LeadComment;
use App\Models\User;
use App\Models\Employee;
use App\Models\LeadAssignment;
use App\Models\Task;
use App\Models\LeadForm;
use App\Models\LeadQuestion;
use App\Models\LeadAnswer;
use App\Models\Service;
use App\Models\State;

use DataTables;
use Auth;
use DB;
use PDF;


class LeadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    private function act_types()
    {
        return ['1' => 'Waiting', '2'=>'Call', '3'=>'Meeting', '4'=>'Review'];
    }


    private function priorities()
    {
        return ['P0'=>'P0', 'P1'=>'P1', 'P2'=>'P2', 'P3'=>'P3', 'P4'=>'P4'];
    }


    private function employee_list()
    {
        $employees = Employee::with('designation')->where('has_access', 1)->where('status', 1)->get();

        $users = [];
        foreach($employees as $obj)
        {
            $designation = $obj->designation ? $obj->designation->title : 'NULL';
            $users[$obj->user_id] = $obj->name.' - '.$designation;
        }

        return $users;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $phase=false)
    {
        $stage_param = $request->s;
        $start_param = $request->st;
        $end_param = $request->ed;


        // ALL Users
        $employees = Employee::with('designation')->where('has_access', 1)->where('status', 1)->get();
        $users = [];
        foreach($employees as $obj)
        {
            $designation = $obj->designation ? $obj->designation->title : 'NULL';
            $users[$obj->user_id] = $obj->name.' - '.$designation;
        }

        
        
        $services = Service::where('status', 1)->pluck('title', 'id')->toArray();
        $states = State::where('status', 1)->pluck('name', 'id')->toArray();
        $stages = LeadStage::where('status', '=', 1)->pluck('name', 'id')->toArray();
        
        $priorities = $this->priorities();
        $act_types = $this->act_types();

        return view('pages.lead.leads', compact('stage_param', 'priorities', 'act_types', 'users', 'stages', 'phase', 'services', 'states'));
    }



    private function get_sarthi($lead_id, $user_type, $names_only=false)
    {
        $sarthi = LeadAssignment::with(['sarthi'])->whereNotNull('is_sarthi')->where('lead_id', $lead_id)->where('user_type', $user_type)->get();


        if($names_only) {
            // $names = 'Sarthi: ';
            $names = '';
            foreach ($sarthi as $obj) {
                $name = $obj->sarthi ? $obj->sarthi->name : "NA";
                $names .= $name." | ";
            }
            return rtrim($names," | ");
        }
        else {
            return $sarthi;
        }

        
    }

    public function lost_leads($phase=false)
    {
        $employees = Employee::with('designation')->where('has_access', 1)->where('status', 1)->get();

        $users = [];
        foreach($employees as $obj)
        {
            $designation = $obj->designation ? $obj->designation->title : 'NULL';
            $users[$obj->user_id] = $obj->name.' - '.$designation;
        }



        $stages = LeadStage::where('status', '=', 1)->pluck('name', 'id')->toArray();

        return view('pages.lead.dead_leads', compact('users', 'stages', 'phase'));
    }

    public function getLeadsData(Request $request)
    {
        // $data = Lead::latest()->with('assignee')->with('stage');

        
        $lead_stages = [];

        if($request->phase_id) {
            $lead_stages = LeadStage::where('phase', $request->phase_id)->pluck('id')->toArray();
        }
        
        $data = Lead::latest()->with(['assignee'])->with('stage')->with('service')
                        ->when($request->stage_id, function ($query) use ($request) {
                            $query->where('stage_id_fk', $request->stage_id);
                        })
                        ->when($request->service_id, function ($query) use ($request) {
                            $query->where('service_id', $request->service_id);
                        })
                        ->when($request->category, function ($query) use ($request) {
                            $query->where('category', $request->category);
                        })
                        ->when($request->phase_id, function ($query) use ($lead_stages) {
                            $query->whereIn('stage_id_fk', $lead_stages);
                        })
                        ->when($request->age, function ($query) use ($request) {
                            $start_date = date('Y-m-d', strtotime(' - '.$request->age.' days'));
                            $query->where('created_at', '>=', $start_date);
                        })
                        ->when($request->priority, function ($query) use ($request) {
                            $query->where('priority', $request->priority);
                        })
                        ->when($request->crm_id, function ($query) use ($request) {
                            $query->where('crm_id', $request->crm_id);
                        })
                        ->when($request->from_date, function ($query) use ($request) {
                            $query->where('created_at', '>=', $request->from_date.' 00:00:00');
                        })
                        ->when($request->to_date, function ($query) use ($request) {
                            $query->where('created_at', '<=', $request->to_date.' 23:59:59');
                        })
                        ->get();
        
       
        return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('assignee', function($row){
                        $name =  !is_null($row->assigned_to) ? $row->assignee->name : "";
                        return $name;
                     })

                     ->addColumn('service', function($row){
                        $name =  !is_null($row->service) ? $row->service->title : "";
                        return $name;
                     })

                     ->addColumn('lead_age', function($row){
                        return (round((time() - strtotime($row->created_at)) / (60 * 60 * 24)))." Days";
                     })

                ->addColumn('client', function($row){
                        return $row->first_name.' '.$row->last_name;
                     })

                ->addColumn('stage', function($row){
                        return !is_null($row->stage) ? $row->stage->name : '';
                     })
                ->editColumn('updated_at', function($row){
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();
                     })
                ->editColumn('created_at', function($row){
                    return date('d M, Y', strtotime($row->created_at));
                })

                ->addColumn('action', function($row){

                        $btn = '<a href='.url('/lead/details/'.$row->id).' title="View Lead Details" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>';

                        $btn = $btn.' <a href='.url('lead/edit/'.$row->id).' title="edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';

                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm assignLead"><i class="fa fa-user"></i></a>';
                        
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Mark Comment" class="edit btn btn-success btn-sm commentLead"><i class="fa fa-comment"></i></a>';

                        // $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete Lead" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';

                        return $btn;
                })
                ->rawColumns(['action', 'activity', 'details', 'lead_age'])
                ->make(true);
    }

    public function getDeadLeadsData(Request $request)
    {
        // $data = Lead::latest()->with('assignee')->with('stage');

        $lead_stages = [];

        if($request->phase_id) {
            $lead_stages = LeadStage::where('phase', $request->phase_id)->pluck('id')->toArray();
        }
        
        $data = Lead::latest()->where('stage_id_fk', 99)->with('assignee')->with('stage')
                        ->when($request->stage_id, function ($query) use ($request) {
                            $query->where('stage_id_fk', $request->stage_id);
                        })
                        ->when($request->service_id, function ($query) use ($request) {
                            $query->where('service_id', $request->service_id);
                        })
                        ->when($request->category, function ($query) use ($request) {
                            $query->where('category', $request->category);
                        })
                        ->when($request->phase_id, function ($query) use ($lead_stages) {
                            $query->whereIn('stage_id_fk', $lead_stages);
                        });

        return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('assignee', function($row){
                        $name =  !is_null($row->assigned_to) ? $row->assignee->name : "";
                        return $name;
                     })
                
                     ->addColumn('lead_age', function($row){
                        return round((time() - strtotime($row->created_at)) / (60 * 60 * 24));
                     })

                ->addColumn('client', function($row){
                        return $row->first_name.' '.$row->last_name;
                     })

                ->addColumn('stage', function($row){
                        return "Dead";
                     })
                ->editColumn('updated_at', function($row){
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();
                     })

                ->addColumn('action', function($row){

                        $btn = '<a href='.url('/lead/details/'.$row->id).' title="View Lead Details" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>';

                        // $btn = $btn.' <a href='.url('lead/edit/'.$row->id).' title="edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';

                        // $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm assignLead"><i class="fa fa-user"></i></a>';

                        // $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete Lead" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';

                        return $btn;
                })
                ->rawColumns(['action', 'activity', 'lead_age'])
                ->make(true);
    }



    public function create()
    {
        $stages = LeadStage::where('status', '=', 1)->pluck('name', 'id')->toArray();
        $states = State::where('status', 1)->pluck('name', 'id')->toArray();
        $sources = CustomerSource::where('status', '=', 1)->pluck('name', 'id')->toArray();
        $services = Service::where('status', 1)->pluck('title', 'id')->toArray();

        return view('pages/lead/lead_create', compact('stages', 'sources', 'states', 'services'));
    }


    public function edit($lead_id)
    {
        $stages = LeadStage::where('status', '=', 1)->pluck('name', 'id')->toArray();

        $sources = CustomerSource::where('status', '=', 1)->pluck('name', 'id')->toArray();

        $states = State::where('status', 1)->pluck('name', 'id')->toArray();
        $services = Service::where('status', 1)->pluck('title', 'id')->toArray();
        $lead = Lead::find($lead_id);

        return view('pages/lead/lead_create', compact('lead', 'stages', 'sources', 'lead_id', 'states', 'services'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'stage_id_fk' => 'required',
            'first_name' => 'required',
            'phone' => 'required',
        ],
        [
            'source_id_fk.required' => 'Source is required.',
            'first_name.required' => 'Client Name is required.',
            'phone.required' => 'Phone is required.',
        ]);


        $res = Lead::updateOrCreate(
                            ['id' => $request->lead_id],
                            [
                                'company_id'=>Auth::user()->company_id,
                                'source_id_fk'=>$request->source_id_fk,
                                'title'=>$request->title,
                                'stage_id_fk'=>$request->stage_id_fk,
                                'est_amount'=>$request->est_amount,
                                'service_id'=>$request->service_id,
                                'property_id'=>$request->property_id,
                                'category'=>$request->category,
                                'first_name'=>ucwords($request->first_name),
                                'last_name'=>ucwords($request->last_name),
                                'company'=>ucwords($request->company),
                                'email'=>strtolower($request->email),
                                'phone'=>$request->phone,
                                'address'=>$request->address,
                                'description'=>$request->description,
                                'remarks'=>$request->remarks,
                                'state_id'=>$request->state_id,
                                'city'=>$request->city,
                                'source_type'=>$request->source_type,
                                'service_id'=>$request->service_id
                            ]
                        );

        


        if($res){

            if(empty($res->title)) {

                $cnt_padded = sprintf("%04d", $res->id);
                $title = "LEAD".date("y").'-'.$cnt_padded;

                $lead = Lead::find($res->id);
                $lead->title = $title;
                $lead->save();
            }

            $msg = $request->lead_id ? "Great! Lead Updated Successfully." : "Great! Lead Added Successfully." ;
        }
        else{
            $msg = "Sorry! There might be some error. Please try again.";
        }
        return response()->json(['msg'=>$msg]);
    }




    public function getLeadData(Request $request, $id)
    {
        $data = Lead::find($id);
        return response()->json($data);
    }




    public function details($id)
    {

        $forms = LeadForm::where('status', 1)->pluck('title', 'id')->toArray();

        $data = Lead::with(['assignee'])->find($id);

        $comments = LeadComment::where('lead_id_fk', '=', $id)->orderBy('created_at', 'desc')->get();
        $stages = LeadStage::where('status', '=', 1)->pluck('name', 'id')->toArray();
        $sources = CustomerSource::where('status', '=', 1)->pluck('name', 'id')->toArray();
        $lead_acts = LeadActivity::with(['user', 'activity_user'])->where('lead_id_fk', '=', $id)->orderBy('created_at', 'desc')->get();



        $employees = Employee::with('designation')->where('has_access', 1)->where('status', 1)->get();

        $users = [];
        foreach($employees as $obj)
        {
            $designation = $obj->designation ? $obj->designation->title : 'NULL';
            $users[$obj->user_id] = $obj->name.' - '.$designation;
        }

        $priorities = $this->priorities();
        $act_types = $this->act_types();

        return view('pages.lead.lead_details', compact('data', 'priorities', 'act_types', 'comments', 'stages', 'sources', 'lead_acts', 'users', 'forms'));
    }


    

    
    public function store_comment_from_list(Request $request)
    {
        $lead = Lead::find($request->lead_id_c);

        if(!empty($request->stage_id_c) && $request->stage_id_c != $lead->stage_id_fk) {
            $new_stage = $request->stage_id_c;
        }
        else {
            $new_stage = $lead->stage_id_fk;
        }
        

        $comment = new LeadComment();

        $comment->lead_id_fk = $request->lead_id_c;
        $comment->comment = $request->comment;
        $comment->priority = $request->priority_c;
        $comment->old_stage = $lead->stage_id_fk;
        $comment->new_stage = $new_stage;
        $comment->created_by = Auth::user()->id;

        if($comment->save())
        {
            if(!empty($request->stage_id_c)) {
                $lead->stage_id_fk = $request->stage_id_c;
                $lead->save();
            }

            if(!empty($request->priority_c)) {
                $lead_data = Lead::find($request->lead_id_c);
                $lead_data->priority = $request->priority_c;
                $lead_data->save();
            }

            return response()->json(['success'=>true, 'msg'=>'Comment has been saved successfully.']);
        }
    }


    public function store_comment(Request $request)
    {
        $lead = Lead::find($request->lead_id_fk);

        if(!empty($request->stage_id_fk) && $request->stage_id_fk != $lead->stage_id_fk) {
            $new_stage = $request->stage_id_fk;
        }
        else {
            $new_stage = $lead->stage_id_fk;
        }
        

        $comment = new LeadComment();

        $comment->lead_id_fk = $request->lead_id_fk;
        $comment->comment = $request->comment;
        $comment->priority = $request->priority;
        $comment->old_stage = $lead->stage_id_fk;
        $comment->new_stage = $new_stage;
        $comment->created_by = Auth::user()->id;

        if($comment->save())
        {
            if(!empty($request->stage_id_fk)) {
                $lead->stage_id_fk = $request->stage_id_fk;
                $lead->save();
            }

            if(!empty($request->priority)) {
                $lead_data = Lead::find($request->lead_id_fk);
                $lead_data->priority = $request->priority;
                $lead_data->save();
            }

            $request->session()->flash('success', 'Comment has been saved successfully.');

            return redirect()->back()->with('msg', 'Comment has been saved successfully.');
        }
    }



    public function store_waiting(Request $request)
    {
        $lead = Lead::find($request->lead_id_fk);

        if(!empty($request->stage_id_fk) && $request->stage_id_fk != $lead->stage_id_fk) {
            $new_stage = $request->stage_id_fk;
        }
        else {
            $new_stage = $lead->stage_id_fk;
        }
        

        $act = new LeadActivity();
        $act->lead_id_fk = $request->lead_id_fk;
        $act->waiting_days = $request->waiting_days;
        $act->description = $request->description;
        $act->activity_type = 1;
        $act->priority = $request->priority;
        $act->status = 1;
        $act->old_stage = $lead->stage_id_fk;
        $act->new_stage = $new_stage;
        $act->created_by = Auth::user()->id;
        if($act->save())
        {
            if(!empty($request->stage_id_fk)) {
                $lead->stage_id_fk = $request->stage_id_fk;
                $lead->save();
            }

            // Store as activity
            $users = $this->employee_list();
                
            $task = [];
            $task['title'] = 'Waiting Task';
            $task['lead_id'] = $act->lead_id_fk;
            $task['description'] = 'Next Date to Connect With: '.date('d M, Y', strtotime($act->waiting_days));
            $task['start_date'] = $act->waiting_days;
            $task['status'] = 1;
            $task['type'] = 1;
            $task['priority'] = $act->priority;

            $this->store_activity_as_task($task);            

            $request->session()->flash('success', 'Waiting has been saved successfully.');

            return redirect()->back()->with('msg', 'Waiting has been saved successfully.');
        }
    }


    public function store_call(Request $request)
    {
        $lead = Lead::find($request->lead_id_fk);

        

        if(!empty($request->stage_id_fk) && $request->stage_id_fk != $lead->stage_id_fk) {
            $new_stage = $request->stage_id_fk;
        }
        else {
            $new_stage = $lead->stage_id_fk;
        }

        $act = new LeadActivity();
        $act->lead_id_fk = $request->lead_id_fk;
        $act->act_time = date('Y-m-d H:i:s', strtotime($request->call_date.' '.$request->call_time));
        $act->act_with = ucwords($request->call_with);
        $act->location = ucwords($request->location);
        $act->description = $request->description;
        $act->activity_type = 2;
        $act->priority = $request->priority;
        $act->status = 1;
        $act->old_stage = $lead->stage_id_fk;
        $act->new_stage = $new_stage;
        $act->created_by = Auth::user()->id;
        if($act->save())
        {
            if(!empty($request->stage_id_fk)) {
                $lead->stage_id_fk = $request->stage_id_fk;
                $lead->save();
            }

            // Store as activity
            $users = $this->employee_list();
                
            $task = [];
            $task['title'] = 'Call Task';
            $task['lead_id'] = $act->lead_id_fk;
            $task['description'] = 'Call With: '.$act->act_with.' | Description: '.$act->description;
            $task['start_date'] = $act->act_time;
            $task['type'] = 2;
            $task['status'] = 1;
            $task['priority'] = $act->priority;

            $this->store_activity_as_task($task);

            $request->session()->flash('success', 'Call with '.$request->call_with.' has been saved successfully.');

            return redirect()->back()->with('msg', 'Call with '.$request->call_with.' has been saved successfully.');
        }
    }


    public function store_meeting(Request $request)
    {
        $lead = Lead::find($request->lead_id_fk);

        if(!empty($request->stage_id_fk) && $request->stage_id_fk != $lead->stage_id_fk) {
            $new_stage = $request->stage_id_fk;
        }
        else {
            $new_stage = $lead->stage_id_fk;
        }
        
        $act = new LeadActivity();
        $act->lead_id_fk = $request->lead_id_fk;
        $act->act_time = date('Y-m-d H:i:s', strtotime($request->meeting_date.' '.$request->meeting_time));
        //$act->act_with = ucwords($request->meeting_with);
        $act->location = ucwords($request->location);
        $act->description = $request->description;
        $act->activity_type = 3;
        $act->priority = $request->priority;
        $act->status = 1;
        $act->old_stage = $lead->stage_id_fk;
        $act->new_stage = $new_stage;
        $act->act_slot = $request->act_slot;
        $act->user_id = $request->user_id;
        $act->created_by = Auth::user()->id;

        if($act->save())
        {
            if(!empty($request->stage_id_fk)) {
                $lead->stage_id_fk = $request->stage_id_fk;
                $lead->save();
            }

            // Store as activity
            $users = $this->employee_list();

            $task = [];
            $task['title'] = 'Meeting Task';
            $task['lead_id'] = $act->lead_id_fk;
            $task['description'] = 'Meeting With: '.@$users[$act->user_id].' | Location: '.$act->location.' | Description: '.$act->description;
            $task['start_date'] = $act->act_time;
            $task['type'] = 3;
            $task['priority'] = $act->priority;
            $task['status'] = 1;

            $this->store_activity_as_task($task);

            $request->session()->flash('success', 'Meeting '.$request->meeting_with.' has been saved successfully.');

            return redirect()->back()->with('msg', 'Meeting '.$request->meeting_with.' has been saved successfully.');
        }
    }


    public function store_site_visit(Request $request)
    {
        $lead = Lead::find($request->lead_id_fk);

        if(!empty($request->stage_id_fk) && $request->stage_id_fk != $lead->stage_id_fk) {
            $new_stage = $request->stage_id_fk;
        }
        else {
            $new_stage = $lead->stage_id_fk;
        }
        
        $act = new LeadActivity();
        $act->lead_id_fk = $request->lead_id_fk;
        $act->act_time = date('Y-m-d H:i:s', strtotime($request->site_visit_date.' '.$request->site_visit_time));
        //$act->act_with = ucwords($request->meeting_with);
        //$act->location = ucwords($request->location);
        $act->description = $request->description;
        $act->activity_type = 4;
        $act->priority = $request->priority;
        $act->status = 1;
        $act->user_id = $request->user_id;
        $act->created_by = Auth::user()->id;

        if($act->save())
        {
            if(!empty($request->stage_id_fk)) {
                $lead->stage_id_fk = $request->stage_id_fk;
                $lead->save();
            }

            // Store as activity
            $users = $this->employee_list();

            $task = [];
            $task['title'] = 'Site Visit Task';
            $task['lead_id'] = $act->lead_id_fk;
            $task['description'] = 'Site Visit With: '.@$users[$act->user_id].' | Description: '.$act->description;
            $task['start_date'] = $act->act_time;
            $task['type'] = 4;
            $task['priority'] = $act->priority;
            $task['status'] = 1;

            $this->store_activity_as_task($task);

            $request->session()->flash('success', 'Site Visit '.$request->meeting_with.' has been saved successfully.');

            return redirect()->back()->with('msg', 'Site Visit '.$request->meeting_with.' has been saved successfully.');
        }
    }


    public function store_review(Request $request)
    {
        $lead = Lead::find($request->lead_id_fk);

        

        $act = new LeadActivity();
        $act->lead_id_fk = $request->lead_id_fk;
        $act->waiting_days = $request->waiting_days;
        $act->description = $request->description;
        $act->activity_type = 5;
        $act->priority = $request->priority;
        $act->status = 1;
        $act->created_by = Auth::user()->id;
        if($act->save())
        {
            if(!empty($request->stage_id_fk)) {
                $lead->stage_id_fk = $request->stage_id_fk;
                $lead->save();
            }

            // Store as activity
            $users = $this->employee_list();
                
            $task = [];
            $task['title'] = 'Review Task';
            $task['lead_id'] = $act->lead_id_fk;
            $task['description'] = 'Scheduled Review Date: '.date('d M, Y', strtotime($act->waiting_days));
            $task['start_date'] = $act->waiting_days;
            $task['status'] = 1;
            $task['type'] = 5;
            $task['priority'] = $act->priority;

            $this->store_activity_as_task($task);            

            $request->session()->flash('success', 'Review Task has been saved successfully.');

            return redirect()->back()->with('msg', 'Review Task has been saved successfully.');
        }
    }

    public function store_activity_as_task($data)
    {
        $task = new Task();
        $task->lead_id = $data['lead_id'];
        $task->type = $data['type'];
        $task->title = $data['title'];
        $task->start_date = $data['start_date'];
        $task->end_date = $data['start_date'];
        $task->description = $data['description'];
        $task->priority = $data['priority'];
        $task->status = $data['status'];

        if($task->save()) {
            return true;
        }
        else {
            return false;
        }
    }




    public function get_lead_details($id)
    {
        $data = Lead::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $del = Lead::find($id);
        $del->stage_id_fk = 99;
        $del->save();

        return response()->json(['success'=>'Lead Updated successfully.']);
    }



    public function assign_lead(Request $request)
    {

        $this->validate($request,[
            'lead_id' => 'required',
            'user_id' => 'required',
        ],
        [
            'lead_id.required' => 'Lead is required.',
            'user_id.required' => 'User is required.',
        ]);

        DB::beginTransaction();

        try {
            // Update the old assignments
            $lead = LeadAssignment::where('lead_id', $request->lead_id)->update(['status'=>'0']);

            $lead_data = Lead::find($request->lead_id);

            $data= [];

            if(!empty($request->user_id) && $request->user_id != $lead_data->assigned_to) {
                $obj = new LeadAssignment();
                $obj->lead_id = $request->lead_id;
                $obj->user_type = 1;
                $obj->user_id = $request->user_id;
                $obj->remarks = $request->remarks;
                $obj->status = 1;
                $obj->save();
            }

            
            $lead = Lead::find($request->lead_id);
            $lead->assigned_to = $request->user_id;
            $lead->assigned_at = now();
            $lead->save();

            $employees = Employee::with('designation')->where('has_access', 1)->where('status', 1)->get();
            $users = [];
            foreach($employees as $obj)
            {
                // $designation = $obj->designation ? $obj->designation->title : 'NULL';
                // $users[$obj->user_id] = $obj->name.' - '.$obj->phone;
                $users[$obj->user_id] = $obj->name;
            }
            
            $comment = new LeadComment();

            $comment->lead_id_fk = $request->lead_id;
            $comment->comment = "Lead Assignment Done Successfully! || User: ".@$users[$request->user_id];
            $comment->created_by = Auth::user()->id;
            $comment->save();

            $msg = 'Lead Assigned Successfully!';
        } 
        catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
            $msg = "There might be some error. Try Again!";
        }

        DB::commit();
        
        return response()->json(['success'=>true, 'msg'=>$msg]);
    }


    public function store_sarthi(Request $request)
    {
        // dd($request->all());
        
        $this->validate($request,[
            'lead_id_fk' => 'required',
            'user_type' => 'required',
            'sarthi_id' => 'required'
        ],
        [
            'lead_id_fk.required' => 'Lead is required.',
            'user_type.required' => 'Sarthi Type is required.',
            'sarthi_id.required' => 'Sarthi is required.'
        ]);

        DB::beginTransaction();

        try {
            // Update the old assignments
            $lead = LeadAssignment::where('lead_id', $request->lead_id_fk)->update(['status'=>'0']);

            //Create new Assignment
            $obj = new LeadAssignment();
            $obj->lead_id = $request->lead_id_fk;
           
            $obj->user_type = $request->user_type;
            $obj->user_id = $request->sarthi_id;

            $obj->is_sarthi = 1;
            $obj->remarks = $request->remarks;
            $obj->status = 1;
            $obj->save();

            $msg = 'Sarthi Assigned Successfully!';
        } 
        catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
            $msg = "There might be some error. Try Again!";
        }

        DB::commit();
        $request->session()->flash('success', $msg);
        return redirect()->back()->with('msg', $msg);

    }




    public function leads_report(Request $request, $phase=false)
    {
        // ALL Users
        $employees = Employee::with('designation')->where('has_access', 1)->where('status', 1)->get();
        $users = [];
        foreach($employees as $obj)
        {
            $designation = $obj->designation ? $obj->designation->title : 'NULL';
            $users[$obj->user_id] = $obj->name.' - '.$designation;
        }

        
        $services = Service::where('status', 1)->pluck('title', 'id')->toArray();

        $stages = LeadStage::where('status', '=', 1)->pluck('name', 'id')->toArray();
    
        $data = Lead::latest()->with('assignee')->with('stage')->where('stage_id_fk', '!=', 99)->get();

        foreach($data as &$lead)
        {
            $last_activity = LeadActivity::where('lead_id_fk', $lead->id)->orderBy('id', 'DESC')->first();

            $lead->last_activity = $last_activity;
        }

        return view('pages.lead.leads_report', compact('data', 'users', 'stages', 'phase', 'services'));


    }


    public function getLeadsReportData(Request $request)
    {
        // $data = Lead::latest()->with('assignee')->with('stage');

        $lead_stages = [];

        if($request->phase_id) {
            $lead_stages = LeadStage::where('phase', $request->phase_id)->pluck('id')->toArray();
        }

        $act_types = array('1' => 'Waiting', '2'=>'Call', '3'=>'Meeting');

        
        $data = Lead::latest()->where('stage_id_fk', '!=', 99)->with(['assignee', 'currentJob', 'lastComment'])->with('stage')->with('project')
                        ->when($request->stage_id, function ($query) use ($request) {
                            $query->where('stage_id_fk', $request->stage_id);
                        })
                        ->when($request->service_id, function ($query) use ($request) {
                            $query->where('service_id', $request->service_id);
                        })
                        ->when($request->category, function ($query) use ($request) {
                            $query->where('category', $request->category);
                        })
                        ->when($request->phase_id, function ($query) use ($lead_stages) {
                            $query->whereIn('stage_id_fk', $lead_stages);
                        })
                        ->when($request->age, function ($query) use ($request) {
                            $start_date = date('Y-m-d', strtotime(' - '.$request->age.' days'));
                            $query->where('created_at', '>=', $start_date);
                        })
                        ->when($request->priority, function ($query) use ($request) {
                            $query->where('priority', $request->priority);
                        })
                        ->when($request->crm_id, function ($query) use ($request) {
                            $query->where('crm_id', $request->crm_id);
                        })
                        ->when($request->rm_id, function ($query) use ($request) {
                            $query->where('rm_id', $request->rm_id);
                        })
                        ->when($request->nc_id, function ($query) use ($request) {
                            $query->where('nc_id', $request->nc_id);
                        })
                        ->when($request->head_id, function ($query) use ($request) {
                            $query->where('head_id', $request->head_id);
                        })
                        ->when($request->from_date, function ($query) use ($request) {
                            $query->where('created_at', '>=', $request->from_date.' 00:00:00');
                        })
                        ->when($request->to_date, function ($query) use ($request) {
                            $query->where('created_at', '<=', $request->to_date.' 23:59:59');
                        })
                        ->get();
                        

        return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('assignee', function($row){
                        $name =  !is_null($row->assigned_to) ? $row->assignee->name : "";
                        return $name;
                     })
                     ->addColumn('service', function($row){
                        $name =  !is_null($row->service) ? $row->service->title : "";
                        return $name;
                     })

                    //  ->addColumn('rm_name', function($row){
                    //     $name =  !is_null($row->rm) ? $row->rm->name : "";
                    //     return $name;
                    //  })

                    //  ->addColumn('crm_name', function($row){
                    //     $name =  !is_null($row->crm) ? $row->crm->name : "";
                    //     return $name;
                    //  })

                    ->addColumn('rm_name', function($row){
                        $name =  !is_null($row->rm) ? $row->rm->name : "";
                        $rm_sarthi = $this->get_sarthi($row->id, 2, true);
                        return $name.' || '.$rm_sarthi;
                     })

                     ->addColumn('crm_name', function($row){
                        $name =  !is_null($row->crm) ? $row->crm->name : "";
                        $crm_sarthi = $this->get_sarthi($row->id, 3, true);
                        return $name.' || '.$crm_sarthi;
                     })
                     ->addColumn('nc_name', function($row){
                        $name =  !is_null($row->nc) ? $row->nc->name : "";

                        $nc_sarthi = $this->get_sarthi($row->id, 1, true);
                        return $name.' || '.$nc_sarthi;
                     })
                     ->addColumn('head_name', function($row){
                        $name =  !is_null($row->head) ? $row->head->name : "";
                        $head_sarthi = $this->get_sarthi($row->id, 4, true);
                        return $name.' || '.$head_sarthi;
                     })



                     ->addColumn('activity', function($row) use ($act_types){
                        $name =  !is_null($row->currentJob) ? @$act_types[$row->currentJob->activity_type] : "NA";
                        return $name;
                     })

                    ->addColumn('details', function($row){
                        if(!is_null($row->currentJob)) {
                            $data = "";
                            if($row->currentJob && $row->currentJob->activity_type==1){
                                $data = "Next Date to Connect with: ".date('d M, Y', strtotime($row->currentJob->waiting_days))." || ";
                            }
                            elseif($row->currentJob && $row->currentJob->activity_type==2){
                                $data = "Call Time: ".date('d M, Y H:i', strtotime($row->currentJob->act_time))." || ";
                            }
                            elseif($row->currentJob && $row->currentJob->activity_type==3){
                                $data = "Meeting Time: ".date('d M, Y H:i', strtotime($row->currentJob->act_time))." || ";
                                                    
                                $data .= "Meeting With: ".($row->currentJob->activity_user ? $row->currentJob->activity_user->name : "NA")." || ";

                                $data .= "Meeting Location: ".$row->currentJob->location." || ";

                                $data .= "Meeting Slot: ".$row->currentJob->act_slot." || " ;
                            }

                            if($row->currentJob)
                            {
                                $data .= "Description: ".$row->currentJob->description." || ";
                                $data .= "By: ".$row->currentJob->user->name;
                                // $data .= "By: ".$row->currentJob->user->name." || ";
                                // $data .= "Time: ".date('d M, Y H:i', strtotime($row->currentJob->created_at));
                            }
                        }
                        else {
                            $data = "NA";
                        }

                        return $data;
                     })

                     ->addColumn('last_comment', function($row) {
                        return $row->lastComment ? $row->lastComment->comment : "";
                    })
                     
                     ->addColumn('lead_age', function($row){
                        return (round((time() - strtotime($row->created_at)) / (60 * 60 * 24)))." Days";
                     })
                     ->addColumn('target_closure_date', function($row){
                        return date('d M, Y', strtotime($row->created_at.' + 45 days'));
                     })

                ->addColumn('client', function($row){
                        return $row->first_name.' '.$row->last_name;
                     })

                ->addColumn('stage', function($row){
                        return $row->stage->name;
                     })
                ->editColumn('updated_at', function($row){
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();
                     })

                     ->editColumn('created_at', function($row){
                        return date('d M, Y', strtotime($row->created_at));
                    })

                ->addColumn('action', function($row){

                        $btn = '<a href='.url('/lead/details/'.$row->id).' title="View Lead Details" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>';

                        $btn = $btn.' <a href='.url('lead/edit/'.$row->id).' title="edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';

                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm assignLead"><i class="fa fa-user"></i></a>';

                        // $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete Lead" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';

                        return $btn;
                })
                ->rawColumns(['action', 'activity', 'lead_age'])
                ->make(true);
    }





    public function generateLeadDetails(Request $request)
    {
        $lead_id = $request->e;

        $lead = Lead::with(['assignee'])->find($lead_id);

        $comments = LeadComment::where('lead_id_fk', '=', $lead_id)->orderBy('created_at', 'desc')->get();
        $stages = LeadStage::where('status', '=', 1)->pluck('name', 'id')->toArray();
        $sources = CustomerSource::where('status', '=', 1)->pluck('name', 'id')->toArray();
        $lead_acts = LeadActivity::with(['user', 'activity_user'])->where('lead_id_fk', '=', $lead_id)->orderBy('created_at', 'desc')->get();

        $employees = Employee::with('designation')->where('has_access', 1)->where('status', 1)->get();

        $users = [];
        foreach($employees as $obj)
        {
            // $designation = $obj->designation ? $obj->designation->title : 'NULL';
            // $users[$obj->user_id] = $obj->name.' - '.$obj->phone;
            $users[$obj->user_id] = $obj->name;
        }
             
        $assignments = LeadAssignment::with('sarthi')->where('lead_id', $lead_id)->get();

        $nice_answers = LeadAnswer::with('question')->where('form_id', 1)->where('lead_id', $lead->id)->get();
        $bant_answers = LeadAnswer::with('question')->where('form_id', 2)->where('lead_id', $lead->id)->get();
        
        $data = [
            'title' => 'Lead Details Document',
            'date' => date('d M, Y H:i'),
            'lead_data' => $lead,
            'stages' => $stages,
            'sources' => $sources,
            'lead_acts' => $lead_acts,
            'comments' => $comments,
            'users' => $users,
            'assignments'=>$assignments,
            'nice_answers'=>$nice_answers,
            'bant_answers'=>$bant_answers
        ];

        if(isset($request->export) && $request->export == 'pdf') {
            view()->share('data',$data);
            $pdf = PDF::loadView('view-modals/lead_details_report')->setPaper('a4', 'portrait');
            return $pdf->download('lead_details_report.pdf');
        }
        else {
            return view('view-modals/lead_details_report', compact('data'));
        }
    }


    public function lead_form($lead_id, $id)
    {
        $data = Lead::find($lead_id);
        $form = LeadForm::find($id);
        $forms = LeadForm::where('status', 1)->pluck('title', 'id')->toArray();
        $questions = LeadQuestion::where('status', 1)->where('form_id', $id)->get();
        $stages = LeadStage::where('status', '=', 1)->pluck('name', 'id')->toArray();
        $answers = LeadAnswer::where('lead_id', $lead_id)->where('form_id', $id)->pluck('answer', 'question_id')->toArray();
        return view('pages.lead.lead_form', compact('data', 'questions', 'form', 'forms', 'answers', 'stages'));
    }



    public function store_form_data(Request $request)
    {
        $data = $request->toArray();

        $lead_id = $request->lead_id;
        $form_id = $request->form_id;

        $update = LeadAnswer::where('lead_id', $lead_id)->where('form_id', $form_id)->update(['status'=>2]);

        unset($data['lead_id']);
        unset($data['form_id']);
        unset($data['_token']);

        foreach($data as $key => $answer) {
            $obj = new LeadAnswer();
            $obj->company_id = Auth::user()->company_id;
            $obj->lead_id = $lead_id;
            $obj->form_id = $form_id;
            $obj->question_id =  ltrim($key,"answer_");

            $ans = is_array($answer) ? implode(' || ', $answer) : $answer; 

            $obj->answer = $ans;
            $obj->status = 1;
            $obj->save();
        }
        
        $request->session()->flash('success', 'Form Details has been saved successfully.');
        return redirect()->back()->with('msg', 'Form Details has been saved successfully.');
    }


}
