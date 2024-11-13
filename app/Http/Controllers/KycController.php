<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Auth;
use DataTables;

use App\Models\KycDetail;
use App\Models\Dealer;
use App\Models\Influencer;
use App\Models\Distributor;
use Illuminate\Http\Request;

class KycController extends Controller
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
        return view('pages/kyc/kyc-list');        
    }

    public function getKycsData()
    {
        $data = KycDetail::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $statuses = [1=>'Under Review', 2=>'Accepted', 3=>'Rejected'];
                    $icon = '<span class="badge bg-primary">'.@$statuses[$row->status].'</span>';
                    return $icon;
                })
                ->addColumn('image', function($row){
                    $file = $row->kyc_document_image;
                    $glob = '<img src="'.asset("kyc")."/".$file.'" style="width:40px"">';
                    return $glob;
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 


                     ->editColumn('title', function($row){
                        if($row->user_type == 'Dealer')
                        {
                            return !is_null($row->dealer) ? $row->dealer->name : "Empty";
                        }
                        elseif($row->user_type == 'Distributer')
                        {
                            return !is_null($row->distributer) ? $row->distributer->name : "Empty";
                        }
                        else{
                            return !is_null($row->influencer) ? $row->influencer->name : "Empty";
                        }
                        
                    })
                ->addColumn('action', function($row){
                    if($row->user_type == 'Dealer')
                    {
                        $result =  !is_null($row->dealer) ? $row->dealer->name : "Empty";
                    }
                    elseif($row->user_type == 'Distributer')
                    {
                        $result = !is_null($row->distributer) ? $row->distributer->name : "Empty";
                    }
                    else{
                        $result = !is_null($row->influencer) ? $row->influencer->name : "Empty";
                    }
                    $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-name="'.$result.'"  data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a></abbr>';

                       //$btn = $btn.' <a href='.url('product/create/'.$row->id).' data-toggle="tooltip"  data-original-title="Add Product" class="btn btn-success btn-sm"><i class="bx bx-plus"></i></a>';

                       $btn = $btn.' <abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a></abbr>';

                        return $btn;
                })
                ->rawColumns(['status','image' ,'action'])
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
        $this->validate($request, ['kyc_date'=>'required','status'=>'required']); 
        $data= KycDetail::find($request->kyc_id);

        KycDetail::where('id', $request->kyc_id)
        ->update([
            'remarks' => $request->remarks,
            'status' => $request->status,
            'kyc_date' => $request->kyc_date
        ]);


        if($data->user_type == 'Dealer')
        {
          $update = Dealer::find($data->user_id);
        }
        elseif($data->user_type == 'Influencer')
        {
            $update = Influencer::find($data->user_id);
        }
        else
        {
            $update = Distributor::find($data->user_id);
        }

        $update->update(['is_kyc' => $request->status]);

        $msg = "Kyc Updated Successfully.";
        
        return response()->json(['msg'=>$msg]);
    }

    public function storenew(Request $request)
    {
        $this->validate($request, ['user_type'=>'required','kyc_document_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048','user_id'=>'required','kyc_document_id'=>'required','kyc_document_no'=>'required']); 

        $image = $request->file('kyc_document_image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('kyc'), $imageName);
        
        KycDetail::updateOrCreate(
                                    [
                                        'user_type' => ucwords($request->user_type),
                                        'kyc_document_image' =>$imageName,
                                        'user_id'=>$request->user_id,
                                        'kyc_ref_no'=>'lpk-'. time(),
                                        'kyc_document_id'=>$request->kyc_document_id,
                                        'kyc_document_no'=>$request->kyc_document_no,
                                        'status'=>1,
                                    ]
                                );   
                                
        if($request->user_type == 'dealer')
        {
          $update = Dealer::find($request->user_id);
        }
        elseif($request->user_type == 'influencer')
        {
            $update = Influencer::find($request->user_id);
        }
        else
        {
            $update = Distributor::find($request->user_id);
        }

        $update->update(['is_kyc' => 1]);

        $msg = "Kyc Submitted Successfully.";
        
        return response()->json(['msg'=>$msg]);
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
    public function edit(string $id)
    {
        $data = KycDetail::find($id);
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
    public function destroy(string $id)
    {
        $del = KycDetail::find($id)->delete();
        return response()->json(['success'=>'Kyc deleted successfully.']);
    }
}
