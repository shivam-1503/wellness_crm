<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpanseCategory;
use App\Models\Expanse;
use App\Models\ExpanseRequest;
use App\Models\Vendor;
use App\Models\VendorDeal;
use App\Models\PaymentTransaction;
use App\Models\Employee;
use App\Models\ExpenseTitle;

use DataTables;
use Auth;
use DB;

class ExpanseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:list-expenses|expense-report|make-bill|make-report', ['only' => ['index','store']]);
        $this->middleware('permission:expense-report', ['only' => ['expense-report']]);
        $this->middleware('permission:vendor-details', ['only' => ['vendor_details']]);
        $this->middleware('permission:make-bill', ['only' => ['expanse_requests','store_request','confirm_expanse_request']]);
        $this->middleware('permission:make-payment', ['only' => ['create_payment']]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cats = ExpanseCategory::whereNull('p_id')->where('status', 1)->pluck('name', 'id')->toArray();
        $vendors = Vendor::where('status', '=', 1)->select("id", DB::raw("CONCAT(name,' - ',business_name) as full_name"))->orderBy('name')->pluck('full_name', 'id')->toArray();
        

        $users = $this->employee_list();
        return view('pages.expanse.expanses', compact('cats', 'vendors', 'users'));
    }


    public function getExpansesData()
    {
        $data = Expanse::latest()->with(['vendor', 'category:id,name', 'sub_category:id,name'])->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("backend_assets/images")."/".$name.'">';
                    return $icon;
                })

                ->editColumn('title', function($row) {
                    return '<a href="javascript:void(0)" data-toggle="tooltip" data-bs-original-title="'.$row->description.'">'.$row->title.'</a>';
                })
                ->editColumn('amount', function($row){ 
                    return number_format($row->amount);                     
                    }) 
                    ->editColumn('balance', function($row){ 
                        return number_format($row->balance);                     
                        }) 

                ->addColumn('category', function($row){
                    return $row->category->name;
                })
                ->addColumn('vendor', function($row){
                    
                    return !is_null($row->vendor) ? $row->vendor->name .' - '. $row->vendor->business_name : "NA";
                })
                ->editColumn('invoice_date', function($row){ 
                    return !is_null($row->invoice_date) ? date('d M, Y', strtotime($row->invoice_date)) : '';                    
                }) 
                ->editColumn('invoice_due_date', function($row){ 
                    return !is_null($row->invoice_due_date) ? date('d M, Y', strtotime($row->invoice_due_date)) : '';                   
                }) 
                ->addColumn('action', function($row){

                        $btn = '';
                        // $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a>';

                        if(!$row->vendor_id) {
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-vendor_id="'.$row->vendor_id.'" data-original-title="Edit" class="make_payment btn btn-primary btn-sm"><i class="fa fa-check"></i> Pay </a>';
                        }
                        // $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';

                        return $btn;
                })

                ->rawColumns(['title', 'status', 'action'])
                ->make(true);
    }


        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['title'=>'required', 'cat_id'=>'required', 'amount' => 'required|numeric']); 
        


        $without_approval_limit = 50000000;
    
        ExpanseRequest::updateOrCreate(
                                ['id' => $request->expanse_id],
                                [
                                    'title' => ucwords($request->title), 
                                    'description'=>$request->description,
                                    'cat_id'=>$request->cat_id,
                                    'sub_cat_id'=>$request->sub_cat_id,
                                    'vendor_id'=>$request->vendor_id,
                                    'amount'=>$request->amount,
                                    'invoice_ref'=>$request->invoice_ref,
                                    'invoice_date'=>$request->invoice_date,
                                    'invoice_due_date'=>$request->invoice_due_date,
                                ]
                            );        
        if($request->expanse_id){
            $msg = "Expanse Request Successfully.";
        }
        else{
            $msg = "Expanse Request Created Successfully.";
        }
        $success = true;

        return response()->json(['success'=>$success, 'msg'=>$msg]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cats = Expanse::find($id);
        return response()->json($cats);
    }


    public function destroy($id)
    {
        $del = ExpanseCategory::find($id)->delete();
        return response()->json(['success'=>'Expanse Category deleted successfully.']);
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
    public function expanse_requests(Request $request)
    {
        $stage = $request->s;
        $vendors = Vendor::where('status', '=', 1)->select("id", DB::raw("CONCAT(name,' - ',business_name) as full_name"))->orderBy('name')->pluck('full_name', 'id')->toArray();
        $cats = ExpanseCategory::whereNull('p_id')->where('status', 1)->pluck('name', 'id')->toArray();


        $users = $this->employee_list();

        return view('pages.expanse.expanse_requests', compact('cats', 'vendors', 'stage', 'users'));
    }


    public function getExpanseRequestsData(Request $request)
    {
        $data = ExpanseRequest::latest()->with(['vendor:id,name,business_name', 'category:id,name', 'sub_category:id,name'])
                            ->when($request->stage, function ($query) use ($request) {
                                $query->where('status', $request->stage);
                            })
                            ->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("backend_assets/images")."/".$name.'">';
                    return $icon;
                })

                ->editColumn('title', function($row) {
                    return '<a href="javascript:void(0)" data-toggle="tooltip" data-bs-original-title="'.$row->description.'">'.$row->title.'</a>';
                })
                ->editColumn('amount', function($row){ 
                    return number_format($row->amount);                     
                    }) 
                ->addColumn('category', function($row){
                    return $row->category->name;
                })
                ->addColumn('vendor', function($row) {
                    return $row->vendor ? $row->vendor->name .' - '. $row->vendor->business_name : "NA";
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){

                        $btn = '';
                        // $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a>';

                        if($row->status == 1) {
                            $btn = $btn.' <button type="button" onclick="view_payment('.$row->id.')" title="Accept Payment" data-bs-toggle="tooltip" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Approove</button>';
                            $btn = $btn.' <button type="button" onclick="reject_payment('.$row->id.')" title="Reject Payment" data-bs-toggle="tooltip" class="btn btn-danger btn-sm"><i class="fa fa-check"></i> Reject</button>';
                        }
                        else if($row->status == 2) {
                            $btn = $btn.' <button type="button"  data-toggle="tooltip" data-bs-original-title="'.$row->remarks.'"  data-bs-toggle="tooltip" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Approoved</button>';
                        }
                        else if($row->status == 3) {
                            $btn = $btn.' <button type="button"  data-toggle="tooltip" data-bs-original-title="'.$row->remarks.'"  data-bs-toggle="tooltip" class="btn btn-danger btn-sm"><i class="fa fa-check"></i> Rejected</button>';                         
                        }
                        else {

                        }
                                               
                        // $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';

                        return $btn;
                })
                ->rawColumns(['title', 'status', 'action'])
                ->make(true);
    }


        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_request(Request $request)
    {
        $this->validate($request, ['title'=>'required', 'cat_id'=>'required', 'amount' => 'required|numeric']); 


        $min_aprooval_limit = 50000000;

        $data = [
            'title' => ucwords($request->title), 
            'description'=>$request->description,
            'cat_id'=>$request->cat_id,
            'sub_cat_id'=>$request->sub_cat_id,
            'vendor_id'=>$request->vendor_id,
            'amount'=>$request->amount,
            'invoice_ref'=>$request->invoice_ref,
            'invoice_date'=>$request->invoice_date,
            'invoice_due_date'=>$request->invoice_due_date,
            'status'=>1,
        ];

        if($request->amount > $min_aprooval_limit) {
            ExpanseRequest::create($data);
        }
        else {
            $expense = Expanse::create($data);

            $current_balance = $expense->amount;

            $amount_paid = 0;
            $balance = $current_balance;

            

            if($request->vendor_id) {
                $vendor = Vendor::find($request->vendor_id);

                $balance_before = $vendor->current_balance;
                $current_balance = $vendor->current_balance + $expense->amount;

                $vendor->current_balance = $current_balance;
                $vendor->save();

                if($balance_before < 0) {

                    $expense_obj = Expanse::find($expense->id);

                    $advance = abs($balance_before);
                    if($advance > $expense_obj->amount) {
                        $amount_paid = $expense_obj->amount;
                        $balance = 0;
                    }
                    else {
                        $amount_paid = $expense_obj->amount - $advance;
                        $balance = $expense_obj->amount - $amount_paid;
                    }
                }
            }

            $expense_obj = Expanse::find($expense->id);
            $expense_obj->amount_paid = $amount_paid;
            $expense_obj->balance = $balance;
            $expense_obj->save();  

            $payment = new PaymentTransaction();  
            $payment->vendor_id = $expense->vendor_id;
            $payment->expanse_id = $expense->id;
            $payment->title = $expense->title;
            $payment->description = $expense->description;
            $payment->amount = $expense->amount;
            $payment->current_balance = $current_balance;
            $payment->payment_date = $expense->invoice_date;
            $payment->save();

            if($request->vendor_id) {
                $this->get_credit_balance($expense->vendor_id);
            }

        }


             
        if($request->expanse_id){
            $msg = "Expanse Request Updated Successfully.";
        }
        else{
            $msg = "Expanse Request Created Successfully.";
        }
        $success = true;

        return response()->json(['success'=>$success, 'msg'=>$msg]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit_request($id)
    {
        $cats = Expanse::find($id);
        return response()->json($cats);
    }


    public function destroy_request($id)
    {
        $del = ExpanseCategory::find($id)->delete();
        return response()->json(['success'=>'Expanse Category deleted successfully.']);
    }


    public function confirm_expanse_request(Request $request)
    {
        $this->validate($request, ['id'=>'required']); 

        DB::beginTransaction();

        try {
            $obj = ExpanseRequest::find($request->id);
            $obj->remarks = $request->remarks;
            $obj->status = 2;
            $obj->action_by = Auth::user()->id;
            $obj->action_at = now();
            if($obj->save()) {
                $expense = new Expanse();
                $expense->request_id = $obj->id;
                $expense->title = $obj->title;
                $expense->description = $obj->description;
                $expense->cat_id = $obj->cat_id;
                $expense->sub_cat_id = $obj->sub_cat_id;
                $expense->vendor_id = $obj->vendor_id;
                $expense->amount = $obj->amount;
                $expense->invoice_ref = $obj->invoice_ref;
                $expense->invoice_date = $obj->invoice_date;
                $expense->invoice_due_date = $obj->invoice_due_date;
                
                if($expense->save()) {

                    $current_balance = $expense->amount;

                    $amount_paid = 0;
                    $balance = $current_balance;

                    if($expense->vendor_id) {
                        $vendor = Vendor::find($expense->vendor_id);

                        $balance_before = $vendor->current_balance;
                        $current_balance = $vendor->current_balance + $expense->amount;

                        $vendor->current_balance = $current_balance;
                        $vendor->save();

                        if($balance_before < 0) {

                            $expense_obj = Expanse::find($expense->id);

                            $advance = abs($balance_before);
                            if($advance > $expense_obj->amount) {
                                $amount_paid = $expense_obj->amount;
                                $balance = 0;
                            }
                            else {
                                $amount_paid = $expense_obj->amount - $advance;
                                $balance = $expense_obj->amount - $amount_paid;
                            }
                        }
                    }

                    $expense_obj = Expanse::find($expense->id);
                    $expense_obj->amount_paid = $amount_paid;
                    $expense_obj->balance = $balance;
                    $expense_obj->save();  

                    $payment = new PaymentTransaction();  
                    $payment->vendor_id = $expense->vendor_id;
                    $payment->expanse_id = $expense->id;
                    $payment->amount = $expense->amount;
                    $payment->current_balance = $current_balance;
                    $payment->payment_date = $expense->invoice_date;

                    $payment->save();

                    if($expense->vendor_id) {
                        $this->get_credit_balance($expense->vendor_id);
                    }
                }

            }

            $msg = 'Expense Request Approved Successfully!';
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

    public function reject_expanse_request(Request $request)
    {
        $this->validate($request, ['id'=>'required']); 

        DB::beginTransaction();

        try {
            $obj = ExpanseRequest::find($request->id);
            $obj->remarks = $request->remarks;
            $obj->status = 3;
            $obj->action_by = Auth::user()->id;
            $obj->action_at = now();
            $obj->save();

            $msg = 'Expense Request Rejected Successfully!';
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




    public function create_payment(Request $request)
    {
        $this->validate($request, ['payment_mode'=>'required', 'amount_paid' => 'required|numeric']);
       

        if($request->expanse_id && !$request->vendor_id) {
            $expense = Expanse::find($request->expanse_id);
            if($expense->balance < $request->amount_paid) {
                return response()->json(['success'=>false, 'msg'=>"You could not pay higher than allowed expense amount."]);
            }
        }

        DB::beginTransaction();

        try {

            $obj = new PaymentTransaction();
            $obj->expanse_id = $request->expanse_id;
            $obj->vendor_id = $request->vendor_id;
            $obj->amount_paid = $request->amount_paid;
            $obj->payment_mode = $request->payment_mode;
            $obj->payment_date = $request->payment_date;
            $obj->payment_by = $request->payment_by;
            $obj->payment_ref = $request->payment_ref;
            $obj->title = $request->title;
            $obj->description = $request->description;
            $obj->status = 1;
            $obj->save();
            
            if($obj->save()) {
                
                $payment_balance = 0;

                if($request->expanse_id) {
                    $expanse = Expanse::find($request->expanse_id);

                    $total_amount = $expanse->amount;
                    $paid_till_date = $expanse->amount_paid;

                    $expanse->amount_paid = $paid_till_date + $request->amount_paid;
                    $expanse->balance = $total_amount - ($paid_till_date + $request->amount_paid);

                    $payment_balance = $expanse->balance;
                    $expanse->save();
                }


                if($request->vendor_id)
                {
                    $vendor = Vendor::find($request->vendor_id);
                    $vendor->current_balance = $vendor->current_balance - $request->amount_paid;
                    $vendor->save();

                    $payment_balance = $vendor->current_balance;

                    $this->get_credit_balance($vendor->id);
                }


                $payment = PaymentTransaction::find($obj->id);
                $payment->current_balance = $payment_balance;
                $payment->save();

                

            }

            $msg = 'Payment Added Successfully!';
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



    public function expense_report(Request $request)
    {
        $vendors = Vendor::where('status', '=', 1)->select("id", DB::raw("CONCAT(name,' - ',business_name) as full_name"))->orderBy('name')->pluck('full_name', 'id')->toArray();
        $cats = ExpanseCategory::whereNull('p_id')->where('status', 1)->pluck('name', 'id')->toArray();
        $users = $this->employee_list();

        return view('pages.expanse.expanse_report', compact('cats', 'vendors', 'users'));
    }


    public function vendor_report(Request $request)
    {
        $vendors = Vendor::where('status', '=', 1)->select("id", DB::raw("CONCAT(name,' - ',business_name) as full_name"))->orderBy('name')->pluck('full_name', 'id')->toArray();
        $cats = ExpanseCategory::whereNull('p_id')->where('status', 1)->pluck('name', 'id')->toArray();
        $users = $this->employee_list();

        return view('pages.expanse.vendor_report', compact('cats', 'vendors', 'users'));
    }



    public function getExpenseReportData(Request $request)
    {
        $data = PaymentTransaction::with(['vendor:id,name,business_name', 'expanse', 'payment_user'])
                                ->leftJoin('expanses', 'expanses.id', 'payment_transactions.expanse_id')
                                ->when($request->stage, function ($query) use ($request) {
                                    $query->where('status', $request->stage);
                                })
                                ->when($request->vendor_id, function ($query) use ($request) {
                                    $query->where('payment_transactions.vendor_id', $request->vendor_id);
                                })
                                ->when($request->cat_id, function ($query) use ($request) {
                                    $query->where('expanses.cat_id', $request->cat_id);
                                })
                                ->when($request->sub_cat_id, function ($query) use ($request) {
                                    $query->where('expanses.sub_cat_id', $request->sub_cat_id);
                                })
                                ->when($request->from_date, function ($query) use ($request) {
                                    $query->where('payment_transactions.payment_date', '>=', $request->from_date.' 00:00:00');
                                })
                                ->when($request->to_date, function ($query) use ($request) {
                                    $query->where('payment_transactions.payment_date', '<=', $request->to_date.' 23:59:59');
                                })
                                ->when($request->user_id, function ($query) use ($request) {
                                    $query->where('payment_transactions.payment_by', $request->user_id);
                                })
                                ->select('payment_transactions.*', 'cat_id', 'sub_cat_id' )
                                ->orderBy('payment_transactions.payment_date', 'ASC')
                                ->get(); 

            
            // $running_balances = 0;

            if(isset($request->from_date) && !empty($request->from_date))
            {
                $running_balances = $this->get_running_balance($request->vendor_id, $request->from_date);
            }
            else {
                $running_balances = 0;
            }
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function($row){
                        $name = $row->status.".png";
                        $icon = '<img src="'.asset("backend_assets/images")."/".$name.'">';
                        return $icon;
                    })
    
                    ->editColumn('title', function($row) {
                        // return $row->expanse ? $row->expanse->title : '-';
                        return $row->title;
                    })

                    ->editColumn('description', function($row) {
                        // return $row->expanse ? $row->expanse->description : '-';
                        return $row->description;
                    })

                    ->editColumn('amount', function($row){ 
                        return number_format($row->amount);                     
                        }) 

                    ->editColumn('amount_paid', function($row){ 
                        return number_format($row->amount_paid);                     
                        }) 

                    // ->editColumn('balance', function($row){ 
                    //     return number_format($row->current_balance);                     
                    //     }) 

                    ->editColumn('balance', function($row) use (&$running_balances){ 
                        $balance = $row->amount - $row->amount_paid;
                        $running_balances =  $running_balances + $balance;
                        return number_format($running_balances);                        
                    }) 

                    ->addColumn('category', function($row){
                        return $row->expanse ? $row->expanse->category->name : '';
                    })
                    
                    ->addColumn('sub_category', function($row){
                        return $row->expanse && $row->expanse->sub_category ? $row->expanse->sub_category->name : 'NA';
                    })
                    ->addColumn('vendor', function($row) {
                        return $row->vendor ? $row->vendor->name .' - '. $row->vendor->business_name : "NA";
                    })

                    ->addColumn('payment_user', function($row) {
                        return $row->payment_user ? $row->payment_user->name : "NA";
                    })

                    ->editColumn('date', function($row){ 
                        return date('d M, Y H:i', strtotime($row->created_at));                     
                     })

                    ->editColumn('updated_at', function($row){ 
                            return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                         }) 
                         ->editColumn('transaction_date', function($row){ 
                            return date('d M, Y', strtotime($row->payment_date));                       
                         }) 
    
                    ->rawColumns(['title', 'status', 'action'])
                    ->make(true);
        
    }


    public function vendor_details(Request $request, $id)
    {
        $vendor_id = $id;

        $vendors = Vendor::where('status', '=', 1)->select("id", DB::raw("CONCAT(name,' - ',business_name) as full_name"))->orderBy('name')->pluck('full_name', 'id')->toArray();
        $cats = ExpanseCategory::whereNull('p_id')->where('status', 1)->pluck('name', 'id')->toArray();
        $users = $this->employee_list();

        $bill_titles = ExpenseTitle::where('type', 'Bill')->pluck('title', 'title')->toArray();
        $payment_titles = ExpenseTitle::where('type', 'Payment')->pluck('title', 'title')->toArray();
        $vendor = Vendor::find($vendor_id);



        return view('pages.expanse.vendor_details', compact('vendor_id', 'vendor', 'vendors', 'cats', 'users', 'bill_titles', 'payment_titles'));
    }



    public function get_credit_balance($vendor_id)
    {
        $vendor = Vendor::find($vendor_id);

        if($vendor) {
            $bills = PaymentTransaction::where('vendor_id', $vendor_id)->sum('amount');
            $payments = PaymentTransaction::where('vendor_id', $vendor_id)->sum('amount_paid');

            $update = Vendor::where('id', $vendor_id)->update(['total_billed_amount'=>$bills, 'total_amount_paid'=>$payments, 'current_balance'=>($bills-$payments)]);

            return $update ? true : false;
        }
        else {
            return false;
        }
    }


    public function get_running_balance($vendor_id, $date)
    {
        $vendor = Vendor::find($vendor_id);

        $till_date = date('Y-m-d', strtotime($date.' -1 day'));

        if($vendor) {
            $bills = PaymentTransaction::where('vendor_id', $vendor_id)->where('payment_date', '<=', $till_date)->sum('amount');
            $payments = PaymentTransaction::where('vendor_id', $vendor_id)->where('payment_date', '<=', $till_date)->sum('amount_paid');

            return $bills - $payments;
        }
        else {
            return false;
        }

    }


    

}
