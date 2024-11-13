<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\State;
use App\Models\Customer;
use App\Models\CustomerSource;
use App\Models\Order;
use App\Models\User;
use DataTables;
use Auth;
use DB;


class CustomerController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.customer.customers');
    }


    public function getCustomersData()
    {
        $data = Customer::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("backend_assets/images")."/".$name.'">';
                    return $icon;
                })
                ->editColumn('name', function($row){ 
                        return $row->first_name.' '.$row->last_name;                     
                     }) 
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){

                       $btn = '<a href='.url('customer/details/'.$row->id).' title="Details" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>';

                       $btn = $btn.' <a href='.url('customer/edit/'.$row->id).' title="Edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';

                       $btn = $btn.' <a href='.url('order/create/'.$row->id).' title="Create Order" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i></a>';

                       $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete Customer" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';

                        return $btn;
                })
                ->rawColumns(['country','status', 'action'])
                ->make(true);
    }



    public function create($cat_id=false)
    {
        $sources = CustomerSource::where('status', '=', 1)->pluck('name', 'id')->toArray();
        $states = State::where('status', '=', 1)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $account_managers = User::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();

        return view('pages.customer.customer_add', compact('sources', 'states', 'account_managers'));
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
            'first_name' => 'required',
            'phone' => 'required|numeric',
            'status' => 'required',
        ],
        [
            'first_name.required' => 'First Name is required.',
            'phone.required' => 'Phone No is required.',
            'phone.numeric' => 'Phone No must be numeric.',
            'status.required' => 'Status is required.',
        ]);

        if(isset($request->customer_id)){
            $this->validate($request, [
              'phone' => 'unique:App\Models\Customer,phone,'.$request->customer_id,
            ]);
        }
        else{
            $this->validate($request,[
              'phone' => 'unique:customers,phone',
            ]);
        }

        $res = Customer::updateOrCreate(
                            ['id' => $request->customer_id],
                            [  
                                'company_id'=>Auth::user()->company_id,
                                'account_manager_id'=>$request->account_manager_id,
                                'source_id'=>$request->source_id,
                                'first_name' => ucwords($request->first_name), 
                                'last_name' => ucwords($request->last_name),
                                'dob'=>$request->dob, 
                                'uidai'=>$request->uidai, 
                                'pan'=>$request->pan, 
                                'email'=>$request->email,
                                'phone'=>$request->phone,
                                'state_id'=>$request->state_id,
                                'city'=>ucwords($request->city),
                                'address'=>$request->address,
                                'pincode'=>$request->pincode,
                                'company'=>ucwords($request->company),
                                'position'=>$request->position,
                                'website'=>$request->website,
                                'status'=>$request->status,
                                'remarks'=>$request->remarks,
                            ]
                        ); 


        // if($request->ajax()){
        //     $customers = Customer::where('status', '=', 1)->select("id", DB::raw("CONCAT(customers.first_name,' ',customers.last_name,' - ',customers.company) as full_name"))->orderBy('customers.first_name')->pluck('full_name', 'id')->toArray();
        //     return response()->json($customers); 
        // }



        if($res){
            $msg = $request->customer_id ? "Great! Customer Updated Successfully." : "Great! Customer Added Successfully." ;
        }
        else{
            $msg = "Sorry! There might be some error. Please try again.";
        }
        return response()->json(['msg'=>$msg, 'customer_id'=>$res->id]);
    
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($customer_id)
    {
        $sources = CustomerSource::where('status', '=', 1)->pluck('name', 'id')->toArray();
        $states = State::where('status', '=', 1)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $account_managers = User::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();

        return view('pages.customer.customer_add', compact('customer_id', 'sources', 'states', 'account_managers'));
    }


    public function details(Request $request, $id)
    {
        $details = Customer::where('id', $id)->with('source')->get()->first();
        
        $orders_data = Order::with(['property:id,title,size', 'project:id,title,city'])->where('customer_id', $id)->get();

        $orders = [];
        foreach($orders_data as $order){
            $orders[$order->id] = $order->order_ref.' | '.$order->property->title.' - '.$order->project->city;
        }


        return view('pages.customer.customer_details', compact('details', 'orders'));
    }



    public function destroy($id)
    {
        $del = Customer::find($id)->delete();
        return response()->json(['success'=>'Customer deleted successfully.']);
    }



}
