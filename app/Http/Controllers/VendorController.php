<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Vendor;
use App\Models\VendorDeal;
use App\Models\ExpanseCategory;
use DataTables;
use Auth;


class VendorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:list-vendors|create-vendor|update-vendor|delete-vendor', ['only' => ['index','store']]);
        $this->middleware('permission:create-vendor', ['only' => ['create','store']]);
        $this->middleware('permission:update-vendor', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-vendor', ['only' => ['destroy']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $states = State::where('status', 1)->pluck('name', 'id')->toArray();
        $categories = ExpanseCategory::where('status', '1')->pluck('name', 'id')->toArray();
        return view('pages.expanse.vendors', compact('states', 'categories'));
    }


    public function getVendorsData()
    {
        $data = Vendor::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("backend_assets/images")."/".$name.'">';
                    return $icon;
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){

                    $btn = '';

                    if(Auth::user()->can('update-vendor')) {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit Vendor" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a>';
                    }
                        // $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Deals in" class="btn btn-primary btn-sm dealsIn"><i class="fa fa-user"></i></a>';
                    if(Auth::user()->can('vendor-details')) {
                        $btn = $btn.' <a href='.url('vendor/details/'.$row->id).' data-toggle="tooltip" data-original-title="Vendor Details" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>';
                    }

                    if(Auth::user()->can('delete-vendor')) {
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';
                    }
                        return $btn;
                })
                ->rawColumns(['country','status', 'action'])
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
        $this->validate($request, ['name'=>'required', 'status'=>'required']); 
        
        Vendor::updateOrCreate(
                                    ['id' => $request->vendor_id],
                                    [
                                        'business_name' => ucwords($request->business_name), 
                                        'name' => ucwords($request->name), 
                                        'position' => ucwords($request->position), 
                                        'state_id'=>$request->state_id,
                                        'address'=>$request->address,
                                        'city'=>ucwords($request->city),
                                        'pincode'=>$request->pincode,
                                        'email'=>strtolower($request->email),
                                        'phone'=>$request->phone,
                                        'pan'=>$request->pan,
                                        'website'=>$request->website,
                                        'status'=>$request->status,
                                        'company_id'=>Auth::user()->company_id,
                                    ]
                                );        
        if($request->vendor_id){
            $msg = "Vendor Updated Successfully.";
        }
        else{
            $msg = "Vendor Created Successfully.";
        }
        return response()->json(['msg'=>$msg]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = Vendor::find($id);
        return response()->json($vendor);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function deals($id)
    {
        $deals = VendorDeal::where('vendor_id', $id)->pluck('expanse_category_id')->toArray();
        return response()->json($deals);
    }



    public function update_vendor_categories(Request $request) 
    {
        $vendor_id = $request->vendor_id;
        $new_cats = $request->deals_in;

        $update = VendorDeal::where('vendor_id', $vendor_id)->delete();

        foreach($new_cats as $key => $cat) {
            $obj = new VendorDeal();
            $obj->vendor_id = $vendor_id;
            $obj->expanse_category_id = $cat;
            $obj->status = 1;
            $obj->save();
        }

        return response()->json(['msg'=> 'Vendor Expanse Categories Updated Successfully!']);

    }



    public function destroy($id)
    {
        $del = Vendor::find($id)->delete();
        return response()->json(['success'=>'Vendor deleted successfully.']);
    }



}
