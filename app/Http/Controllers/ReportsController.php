<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerSource;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStage;
use App\Models\PropertyType;
use App\Models\Project;
use App\Models\OrderEmi;
use App\Models\Company;
use App\Models\CustomerPayment;
use App\Models\InvoiceActivity;


use DataTables;
use Auth;
use PDF;
use DB;


class ReportsController extends Controller
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return false;
    }



    public function payments(Request $request)
    {
        $customers = Customer::where('status', 1)
                        ->select("id", DB::raw("CONCAT(customers.first_name,' ',customers.last_name,' - ',customers.company) as full_name"))
                        ->orderBy('customers.first_name')->pluck('full_name', 'id')->toArray();

        $property_types = PropertyType::where('status', 1)->pluck('name', 'id')->toArray();
        
        $projects = Project::where('status', 1)->pluck('title', 'id')->toArray();

        return view('pages.reports.payment_report', compact('customers', 'projects', 'property_types'));    
    }



    public function get_payments_data(Request $request) 
    {
        $data = DB::table('customer_payments as c')
                    ->leftJoin('order_emis as e', 'c.emi_id', '=', 'e.id')
                    ->leftJoin('orders as o', 'o.id', '=', 'c.order_id')
                    ->leftJoin('customers as cs', 'c.customer_id', '=', 'cs.id')
                    ->when($request->customer_id, function ($query) use ($request) {
                        $query->where('o.customer_id', $request->customer_id);
                    })
                    ->when($request->project_id, function ($query) use ($request)  {
                        $query->where('o.project_id', $request->project_id);
                    })
                    ->when($request->property_type_id, function ($query) use ($request)  {
                        $query->where('o.property_type_id', $request->property_type_id);
                    })
                    ->where('c.status', '!=', 0)
                    ->select('c.id', 'c.customer_id as customer_id', 'e.order_id', 'o.project_id', 'o.property_type_id', 'c.emi_id', 'e.month', 'o.months as total_months', 'c.amount_paid', 'c.payment_mode', 'c.payment_date', 'c.payment_type', 'c.status', 'cs.first_name', 'cs.last_name', 'cs.phone')
                    ->get();


        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){ 
                        return ucwords(strtolower($row->first_name).' '.strtolower($row->last_name));
                        }) 
                ->editColumn('payment_date', function($row){ 
                        return date('d M, Y', strtotime($row->payment_date));                     
                        }) 
                ->editColumn('amount_paid', function($row){ 
                        return 'Rs. '.number_format($row->amount_paid);                     
                        }) 

                ->addColumn('months', function($row){ 
                    $btn = '';
                    if($row->payment_type == 1) {
                        $btn = $btn.' <span class="badge bg-primary"><strong>'.$row->month.' / '.$row->total_months.'</strong></span>';
                    }
                    else {
                        $btn = $btn.' <span class="badge bg-warning"><strong>Balance</strong></span>';
                    } 
                    return $btn;                 
                }) 
                ->editColumn('status', function($row){ 
                    if($row->status == 1) {
                        $btn = '<span class="badge bg-success"><strong>Confirmed</strong></span>';
                    }
                    else if($row->status == 2) {
                        $btn = '<span class="badge bg-danger"><strong>Rejected</strong></span>';
                    }   
                    else {
                        $btn = "";
                    }
                    return $btn;                
                }) 
                ->addColumn('action', function($row){

                        $btn = '';

                        if($row->status == 1) {
                            $btn = $btn.' <button type="button" onclick="show_receipt('.$row->id.')" title="Reciept" class="btn btn-primary btn-sm"><i class="fas fa-receipt"></i> Receipt</button>';
                        }

                        return $btn;
                })
                ->rawColumns(['country','status', 'action', 'months'])
                ->make(true);
        
        return response()->json($data);
    }

    


    public function send_mail(Request $request)
    {
        $to_name = 'Shivam Kashyap';
        $to_email = 'cool.shivi8@gmail.com';
        $data = array('name' => 'Laravel', 'body' => 'A test Mail');

        Mail::send('mails.quote_mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Laravel Test Mail');
            $message->from('shivam15mar@gmail.com', 'Test Mail');
        });
    }




    public function invoices(Request $request)
    {
        $customers = Customer::where('status', 1)
                        ->select("id", DB::raw("CONCAT(customers.first_name,' ',customers.last_name,' - ',customers.company) as full_name"))
                        ->orderBy('customers.first_name')->pluck('full_name', 'id')->toArray();

        $property_types = PropertyType::where('status', 1)->pluck('name', 'id')->toArray();
        
        $projects = Project::where('status', 1)->pluck('title', 'id')->toArray();

        return view('pages.reports.invoice_report', compact('customers', 'projects', 'property_types'));    
    }



    public function get_invoices_data(Request $request) 
    {
        $data = DB::table('order_emis as e')
                    ->leftJoin('orders as o', 'o.id', '=', 'e.order_id')
                    ->leftJoin('customers as cs', 'e.customer_id', '=', 'cs.id')
                    ->when($request->customer_id, function ($query) use ($request) {
                        $query->where('e.customer_id', $request->customer_id);
                    })
                    ->when($request->project_id, function ($query) use ($request)  {
                        $query->where('o.project_id', $request->project_id);
                    })
                    ->when($request->property_type_id, function ($query) use ($request)  {
                        $query->where('o.property_type_id', $request->property_type_id);
                    });

        
                    if($request->from_date && $request->to_date) {
                        $data = $data->where('e.due_date', '>=', $request->from_date)
                                    ->where('e.due_date', '<=', $request->to_date);
                    } 
                    else {
                        $data = $data->where('e.due_date', 'LIKE', date('Y-m').'%');
                    }
                    
                    $data = $data->select('e.id', 'o.customer_id as customer_id', 'e.order_id', 'o.project_id', 'o.property_type_id', 'e.month', 'o.months as total_months', 'e.emi_amount', 'e.invoice_date', 'e.due_date', 'e.invoice_code', 'e.status', 'cs.first_name', 'cs.last_name', 'cs.phone')
                    ->get();


        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){ 
                        return ucwords(strtolower($row->first_name).' '.strtolower($row->last_name));
                        }) 
                ->editColumn('invoice_date', function($row){ 
                        return date('d M, Y', strtotime($row->invoice_date));                     
                        }) 
                ->editColumn('due_date', function($row){ 
                        return date('d M, Y', strtotime($row->due_date));                     
                        }) 
                ->editColumn('emi_amount', function($row){ 
                        return 'Rs. '.number_format($row->emi_amount);                     
                        }) 

                ->addColumn('months', function($row){ 
                   
                    $btn = ' <span class="badge bg-primary" data-toggle="tooltip" title="'.$row->month.' EMI"><strong>'.$row->month.' / '.$row->total_months.'</strong></span>';
                     
                    return $btn;                 
                }) 
                ->editColumn('status', function($row){ 
                    if($row->status == 1) {
                        $btn = '<span class="badge bg-success"><strong>Confirmed</strong></span>';
                    }
                    else if($row->status == 2) {
                        $btn = '<span class="badge bg-danger"><strong>Rejected</strong></span>';
                    }
                    else if($row->status == 0) {
                        $btn = '<span class="badge bg-warning"><strong>Not Paid</strong></span>';
                    }   
                    else {
                        $btn = "";
                    }
                    return $btn;                
                }) 
                ->addColumn('action', function($row){

                        $btn = '';

                        $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" title="Add Remarks, Calls and Meetings." data-id="'.$row->id.'" data-customer_name="'.ucwords(strtolower($row->first_name).' '.strtolower($row->last_name)).'" data-amount="'.$row->emi_amount.'" class="addDetails btn btn-primary btn-sm"><i class="fa fa-calendar-week"></i></a>';


                        $btn = $btn.' <button data-toggle="tooltip" title="All Activities." data-id="'.$row->id.'" class="showDetails btn btn-primary btn-sm"><i class="fa fa-users"></i></button>';


                        if($row->status == 1) {
                            $btn = $btn.' <button type="button" onclick="show_receipt('.$row->id.')" title="Reciept" class="btn btn-primary btn-sm"><i class="fas fa-receipt"></i> Receipt</button>';
                        }

                        return $btn;
                })
                ->rawColumns(['status', 'action', 'months'])
                ->make(true);
        
        return response()->json($data);
    }




    public function store_invoice_comment(Request $request) 
    {
        $this->validate($request, ['emi_id'=>'required', 'comment'=>'required']); 
                                
        $obj = new InvoiceActivity();
        $obj->emi_id = $request->emi_id;
        $obj->comment = $request->comment;
        $obj->status = 1;
        $obj->activity_type = 1;

        if($obj->save()){
            $msg = "Comment Added Successfully.";
            $success = true;
        }
        else{
            $msg = "There might be some error. Please try again.";
            $success = false;
        }
        return response()->json(['success'=> $success, 'msg'=>$msg]);
    }


    public function store_invoice_waiting(Request $request) 
    {
        $this->validate($request, ['emi_id'=>'required', 'waiting_days'=>'required', 'description' => 'required']); 
                                
        $obj = new InvoiceActivity();
        $obj->emi_id = $request->emi_id;
        $obj->waiting_days = $request->waiting_days;
        $obj->description = $request->description;
        $obj->status = 1;
        $obj->activity_type = 2;

        if($obj->save()){
            $msg = "Waiting Days Added Successfully.";
            $success = true;
        }
        else{
            $msg = "There might be some error. Please try again.";
            $success = false;
        }
        return response()->json(['success'=> $success, 'msg'=>$msg]);
    }



    public function store_invoice_call(Request $request) 
    {
        $this->validate($request, ['emi_id'=>'required', 'call_time' => 'required', 'call_with'=>'required', 'description' => 'required']); 
                                
        $obj = new InvoiceActivity();
        $obj->emi_id = $request->emi_id;
        $obj->act_time = date('Y-m-d H:i:s', strtotime($request->call_time));
        $obj->act_with = ucwords($request->call_with);
        $obj->description = $request->description;
        $obj->status = 1;
        $obj->activity_type = 3;

        if($obj->save()){
            $msg = "Call Details Added Successfully.";
            $success = true;
        }
        else{
            $msg = "There might be some error. Please try again.";
            $success = false;
        }
        return response()->json(['success'=> $success, 'msg'=>$msg]);
    }



    public function store_invoice_meeting(Request $request) 
    {
        $this->validate($request, ['emi_id'=>'required', 'meeting_time'=>'required', 'meeting_with' => 'required', 'location' => 'required', 'description' => 'required']); 
                                
        $obj = new InvoiceActivity();
        $obj->emi_id = $request->emi_id;
        $obj->act_time = date('Y-m-d H:i:s', strtotime($request->meeting_time));
        $obj->act_with = ucwords($request->meeting_with);
        $obj->location = ucwords($request->location);
        $obj->description = $request->description;
        $obj->status = 1;
        $obj->activity_type = 4;

        if($obj->save()){
            $msg = "Meeting Details Added Successfully.";
            $success = true;
        }
        else{
            $msg = "There might be some error. Please try again.";
            $success = false;
        }
        return response()->json(['success'=> $success, 'msg'=>$msg]);
    }


    public function get_all_activities(Request $request) 
    {
        $data = InvoiceActivity::where('emi_id', $request->e)->with(['user:id,name'])->get();


        $icons = [1 => 'comments', 2 => 'stopwatch', 3 => 'phone', 4 => 'handshake'];
        $cls = [1 => 'primary', 2 => 'success', 3 => 'danger', 4 => 'warning'];

        $content = '';

        foreach($data as $key => $obj) {

            $timeline_class = $key % 2 == 0 ? " " : "timeline-inverted";

            
            $content = $content.'<li class='.$timeline_class.'>
            <div class="timeline-badge '.$cls[$obj->activity_type].'">
              <i class="fa fa-'.$icons[$obj->activity_type].'"></i>
            </div>
            <div class="timeline-panel">
            <div class="timeline-heading">
              <h5 class="timeline-title">Meeting <small class="text-muted float-end">07 Dec, 2022</small></h5>
              
            </div>';


            if($obj->comment) {
                $content = $content.'<div class="timeline-body">
                <p>'.$obj->comment.'</p>
            </div>';
            }
            

            $content = $content.'<div class="timeline-body">';

            if($obj->act_with && $obj->act_time) {
                $content = $content.'<p>With '.$obj->act_with.' at '.date('d M, Y H:i', strtotime($obj->act_time)).' </p>';
            }

            $content = $content.'<p>'.$obj->description.'</p></div>';
            
            if($obj->location) {
                $content = $content.'<p><span class="badge bg-'.$cls[$obj->activity_type].'">Location: '.$obj->location.'</span></p>';
            }

            if($obj->waiting_days) {
                $content = $content.'<p><span class="badge bg-'.$cls[$obj->activity_type].'"> '.$obj->waiting_days.' Days</span></p>';
            }

            $content = $content.'<cite> By '.$obj->user->name.' </cite>
          </div>
      </li>';



        }



        if($data) {
            $success = true;
        }
        else {
            $success = false;
        }

        return response()->json(['success'=> $success, 'msg'=>$content]);


    }




/*

    <li class="timeline-inverted">
        <div class="timeline-badge warning">
          <i class="fa fa-handshake"></i>
        </div>
        <div class="timeline-panel">
            <div class="timeline-heading">
              <h5 class="timeline-title">Meeting <small class="text-muted float-end">07 Dec, 2022</small></h5>
              
            </div>
            <div class="timeline-body">
                <p>With Shivam at 8 Dec, 2022 07:00 PM </p>

                <p>Permissions to perform work for the Fort Smith (FOR) office were added by Ric Flair.</p>
            </div>

            <p><span class="badge bg-warning">Location: MGF Mall, Gurugram - 121001</span></p>

            <cite> By Thor in Endgame</cite>
  
          </div>
      </li>
    
*/


}
