<?php

namespace App\Http\Controllers;
use Auth;
use DataTables;

use App\Models\Dealer;
use App\Models\State;
use App\Models\District;
use Illuminate\Http\Request;

class DealerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states=State::pluck('name as state','id')->toarray();
        $districts=District::pluck('title','id')->toarray(); 
        return view('pages/dealer/dealers', compact('states','districts'));
    }

    public function getDealersData()
    {
        $data = Dealer::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    // $name = $row->status.".png";
                    // $icon = '<img src="'.asset("images")."/".$name.'">';
                    // return $icon;

                    $checked = $row->status == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" '. $checked .' ></div>';
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){

                    $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a></abbr>';

                    if($row->is_kyc == 0 || $row->is_kyc == 3){
                        $btn = $btn.' <abbr title="Kyc"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-type="dealer" data-original-title="Edit" class="edit btn btn-primary btn-sm addkyc">Add New KYC</a></abbr>';
                    }
                    elseif($row->is_kyc == 1){
                        $btn = $btn.' <abbr title="kyc"><a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-info btn-sm">KYC Under Review</a></abbr>';
                    }
                    elseif($row->is_kyc == 2){
                        $btn = $btn.' <abbr title="kyc"><a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success btn-sm">KYC Done</a></abbr>';
                    }
                    elseif($row->is_kyc == 3){
                        $btn = $btn.' <abbr title="Kyc"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-type="dealer" data-original-title="Edit" class="edit btn btn-primary btn-sm addkyc">Add KYC</a></abbr>';
                    }

                    $btn = $btn.' <abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a></abbr>';

                    return $btn;
                })
                ->rawColumns(['status','action'])
                ->make(true);
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name'=>'required','date_of_birth'=>'required','mobile'=>'required','permanent_address'=>'required','permanent_state_id'=>'required','permanent_district_id'=>'required','permanent_city'=>'required','permanent_pincode'=>'required','present_address'=>'required','present_state_id'=>'required','present_district_id'=>'required','present_city'=>'required','present_pincode'=>'required','status'=>'required']); 

        Dealer::updateOrCreate(
                                    ['id' => $request->dealer_id],
                                    [
                                        'name' => ucwords($request->name),
                                        'email'=>$request->email,
                                        'date_of_birth'=>$request->date_of_birth,
                                        'aadhar'=>$request->aadhar,
                                        'mobile'=>$request->mobile,
                                        'rating'=>$request->rating,
                                        'type_id'=>$request->type_id,
                                        'permanent_address'=>$request->permanent_address,
                                        'permanent_city'=>$request->permanent_city,
                                        'permanent_state_id'=>$request->permanent_state_id,
                                        'permanent_district_id'=>$request->permanent_district_id,
                                        'permanent_pincode'=>$request->permanent_pincode,
                                        'present_pincode'=>$request->present_pincode,
                                        'present_address'=>$request->present_address,
                                        'present_city'=>$request->present_city,
                                        'present_state_id'=>$request->present_state_id,
                                        'present_district_id'=>$request->present_district_id,
                                        'status'=>$request->status,
                                    ]
                                );        
        if($request->dealer_id){
            $msg = "Dealer Updated Successfully.";
            $success = true;
        }
        else{
            $msg = "Dealer Created Successfully.";
            $success = false;
        }
        return response()->json(['success'=>$success, 'msg'=>$msg]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Dealer::find($id);
        return response()->json($data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $del = Dealer::find($id)->delete();
        return response()->json(['success'=>'Dealer deleted successfully.']);        
    }

    public function finddistrict($id)
    {
        $data = District::where('state_id',$id)->pluck('title','id')->toarray(); 
        return $data;
    }
}
