<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Department;
use App\Models\Employee;
use Spatie\Permission\Models\Permission;


use DataTables;
use Auth;
use PDF;
use Session;

class TaskController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:holiday-list|holiday-create|holiday-edit|holiday-delete|holiday-calender', ['only' => ['index','store']]);
        //  $this->middleware('permission:holiday-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:holiday-calender', ['only' => ['indexFullCalendar']]);
        //  $this->middleware('permission:holiday-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:holiday-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$permission = Permission::get(); 

        $tasks = Task::all();
        // ALL Users
        $employees = Employee::with('designation')->where('has_access', 1)->where('status', 1)->get();
        $users = [];
        foreach($employees as $obj)
        {
            $designation = $obj->designation ? $obj->designation->title : 'NULL';
            $users[$obj->user_id] = $obj->name.' - '.$designation;
        }


        $tasks = Task::where('response_status', 0)->select('type', 'title', 'start_date')->get();
        Session::put('notifications', $tasks);
        
        return view('pages/task/tasks',compact('tasks','users'));
    }

    public function indexFullCalendar()
    { 
        $permission = Permission::get();
        $tasks = Task::all();
        return view('pages/task/tasks-calendar', compact('tasks','permission'));
    }
    


    public function getTasksData(Request $request)
    {
        $data = Task::latest()->with('lead')->orderBy('start_date', 'ASC')
                    ->when($request->task_date, function ($query) use ($request) {
                        $query->where('start_date', '>=',  $request->task_date." 00:00:00");
                    })
                    ->when($request->to_date, function ($query) use ($request) {
                        $query->where('start_date', '<=',  $request->to_date." 23:59:59");
                    })
                    ->when($request->type != '', function ($query) use ($request) {
                        $query->where('type',  $request->type);
                    })
                    ->when($request->response_status, function ($query) use ($request) {
                        $query->where('response_status', $request->response_status);
                    })
                    ->when($request->user_id, function ($query) use ($request) {
                        $query->whereHas('lead', function($q) use ($request){
                            $q->where('user_id', $request->user_id);
                         });
                    })
                    ->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    // $name = $row->response_status.".png";
                    // $icon = '<img src="'.asset("backend_assets/images")."/".$name.'">';
                    // return $icon;

                    if($row->response_status == 1) {
                        return  '<span class="badge bg-success">Completed</span>';
                    }
                    elseif($row->response_status == 0) {
                        return  '<span class="badge bg-danger">Pending</span>';
                    } 
                    else {
                        return "NA";
                    }                    

                })
                ->addColumn('client', function($row){
                    return $row->lead ? $row->lead->first_name.' '.$row->lead->last_name.' | '.$row->lead->phone : "NA";
                })

                

                ->editColumn('start_date', function($row){ 
                    return date('d M, Y h:i a', strtotime($row->start_date));                     
                })

                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                }) 

                ->addColumn('action', function($row){

                        $btn = '';
                       // $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-info btn-sm editProduct"><i class="fa fa-edit"></i></a></abbr>';
                       $btn = $btn.' <abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Submit Response" class="edit btn btn-warning btn-sm responseProduct"><i class="fa fa-edit"></i></a></abbr>';

                       //$btn = $btn.' <a href='.url('product/create/'.$row->id).' data-toggle="tooltip"  data-original-title="Add Product" class="btn btn-success btn-sm"><i class="bx bx-plus"></i></a>';

                       $btn = $btn.' <abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a></abbr>';

                        return $btn;
                })
                ->rawColumns(['status', 'start_date', 'action', 'managers'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['title'=>'required','start_date'=>'required','description'=>'required','status'=>'required']); 
        
        // return ($request->all());

        $end_date = $request->end_date ? $request->end_date : $request->start_date;
        $end_time = $request->end_time ? $request->end_time : $request->start_time;

        Task::updateOrCreate(
                                    ['id' => $request->task_id],
                                    [
                                        'title' => ucwords($request->title),
                                        'start_date'=>$request->start_date.' '.$request->start_time,
                                        'deadline'=>$request->deadline,
                                        'end_date'=>$end_date.' '.$end_time,
                                        'description'=>$request->description,
                                        'priority'=>$request->priority,
                                        'user_id'=>$request->user_id,
                                        'status'=>$request->status,
                                    ]
                                ); 

        if($request->holiday_id){
            $msg = "Task Updated Successfully.";            
        }
        else{
            $msg = "Task Created Successfully.";
        }
        return response()->json(['msg'=>$msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Task::find($id);
        $data->start_date = date('Y-m-d', strtotime($data->start_date));
        $data->start_time = date('H:i', strtotime($data->start_date));
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::get();
        $del = Task::find($id)->delete();
        return response()->json(['success'=>'Task deleted successfully.', $permission]);
    }


    public function store_response(Request $request)
    {
        $this->validate($request, ['response_task_id'=>'required', 'response_status'=>'required']); 

        $task = Task::find($request->response_task_id);

        if($task) {
            $task->response_remarks = $request->remarks;
            $task->response_status = $request->response_status;
            if($task->save())
            {
                $success = true;
                $msg = "Remarks has been recorded successfully!";
            }
            else {
                $success = false;
                $msg = "There might be some error!";
            }
        }


        $tasks = Task::where('response_status', 0)->select('type', 'title', 'start_date')->get();
        Session::put('notifications', $tasks);
        
        return response()->json(['success'=>$success, 'msg'=>$msg]);
    }

    private function getTasks(Request $request) 
    {
        return $data = Task::with(['lead'])->orderByRaw('DATE(start_date)')
        ->when($request->task_date, function ($query) use ($request) {
            $query->where('start_date', '>=',  $request->task_date." 00:00:00");
        })
        ->when($request->to_date, function ($query) use ($request) {
            $query->where('start_date', '<=',  $request->to_date." 23:59:59");
        })
        // ->when($request->type != '', function ($query) use ($request) {
        //     $query->where('type',  $request->type);
        // })
        ->when($request->response_status, function ($query) use ($request) {
            $query->where('response_status', $request->response_status);
        })
        ->when($request->rm_id, function ($query) use ($request) {
            $query->whereHas('lead', function($q) use ($request){
                $q->where('rm_id', $request->rm_id);
             });
        })
        ->when($request->crm_id, function ($query) use ($request) {
            $query->whereHas('lead', function($q) use ($request){
                $q->where('crm_id', $request->crm_id);
             });
        });
    }

    
    public function generateTaskReport(Request $request)
    {
        
                    // ->get(); 

        


        $tasks[1] = $this->getTasks($request)->where('type', 1)->orderBy('priority', 'ASC')->get();
        $tasks[2] = $this->getTasks($request)->where('type', 2)->orderBy('priority', 'ASC')->get();
        $tasks[3] = $this->getTasks($request)->where('type', 3)->orderBy('priority', 'ASC')->get();
        $tasks[4] = $this->getTasks($request)->where('type', 4)->orderBy('priority', 'ASC')->get();
        $tasks[5] = $this->getTasks($request)->where('type', 5)->orderBy('priority', 'ASC')->get();


        $task_count = [];
        array_push($task_count, count($tasks[3]));
        array_push($task_count, count($tasks[4]));
        array_push($task_count, count($tasks[2]));
        array_push($task_count, count($tasks[1]));
        array_push($task_count, count($tasks[5]));

        $task_names = ['Meetings', 'Site visits', 'Calls', 'Waiting', 'Review'];

        Session::put('task_names', $task_names);
        Session::put('task_count', $task_count);

        

        $employees = Employee::with('designation')->where('has_access', 1)->where('status', 1)->get();

        $users = [];
        foreach($employees as $obj)
        {
            $designation = $obj->designation ? $obj->designation->title : 'NULL';
            $users[$obj->user_id] = $obj->name.' - '.$designation;
        }
                
        $data = [
            'title' => 'Lead Details Document',
            'date' => date('d M, Y H:i'),
            'task_data' => $tasks,
            'task_names' => $task_names,
            'task_count' => $task_count,
            'users' => $users
        ];

        if(isset($request->export) && $request->export == 'pdf') {
            view()->share('data',$data);
            $pdf = PDF::loadView('view-modals/tasks_report')->setPaper('a4', 'landscape');
            return $pdf->download('tasks_report.pdf');
        }
        else {
            return view('view-modals/tasks_report', compact('data'));
        }
    }

    public function getTaskStats()
    {

        $task_names = Session::get("task_names");
        $task_count = Session::get("task_count");

        return response()->json(['task_names'=>$task_names, 'task_count'=>$task_count]);
    }


}