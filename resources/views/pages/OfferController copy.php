<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Auth;
use DataTables;

use App\Models\Offer;
use App\Models\State;
use App\Models\District;
use App\Models\Gift;
use App\Models\Offer_state_mapping;
use App\Models\Product;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states=State::pluck('name','id')->toarray();
        $districts=District::pluck('title','id')->toarray(); 
        return view('backend/offer/offers', compact('states','districts'));
    }
    
    
    public function getOffersData()
    {
        $data = Offer::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("images")."/".$name.'">';
                    return $icon;
                })
                ->addColumn('image', function($row){
                    $file = $row->banner;
                    $glob = '<img src="'.asset("offer")."/".$file.'" style="width:40px"">';
                    return $glob;
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->editColumn('sub_category', function($row){
                    return !is_null($row->reports) ? $row->reports->title : "Empty";
                })
                
                ->addColumn('action', function($row){

                    $btn = '<abbr title="View"><a href="'.url("/offer/details/".$row->id).'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="edit btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a></abbr>';

                    $btn = $btn.' <abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'"data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a>';

                    $btn = $btn.' <abbr title="Kyc"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'"data-original-title="Edit" class="edit btn btn-warning btn-sm addkyc"><i class="fa fa-gift"></i></a>';

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
        $this->validate($request, ['title'=>'required','offer_code'=>'required','start_date'=>'required','end_date'=>'required','banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048','description'=>'required','terms'=>'required','state_id'=>'required','district_id'=>'required','status'=>'required', ]); 

        if($request->offer_id)
        {
            $data = Offer::find($request->offer_id);

            $oldImagePath = public_path("offer/{$data->banner}");
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }
        $image = $request->file('banner');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('offer'), $imageName);

        $id = Offer::updateOrCreate(
                                    ['id' => $request->dealer_id],
                                    [
                                        'title' => ucwords($request->title),
                                        'start_date'=>$request->start_date,
                                        'offer_code'=>$request->offer_code,
                                        'end_date'=>$request->end_date,
                                        'banner'=>$imageName,
                                        'description'=>$request->description,
                                        'terms'=>$request->terms,
                                        'status'=>$request->status,
                                    ]
                                ); 

        // foreach ($request->district_id as $district)
        // {
        //     $data = District::find($district);
        //     Offer_state_mapping::UpdateOrCreate(
        //                 [
        //                     'offer_id' => $id->id,
        //                     'district_id' => $district,
        //                     'state_id' => $data->state_id,
        //                     'status' =>1,

        //                 ]
        //     );
        // }
                                
        if($request->offer_id){
            $msg = "Offer Updated Successfully.";
        }
        else{
            $msg = "Offer Created Successfully.";
        }
        return response()->json(['msg'=>$msg]);
    }

    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Offer::find($id);
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
        $del = Offer::find($id)->delete();
        return response()->json(['success'=>'Offer deleted successfully.']);
        
    }



    /**
     * Display the specified resource.
     */
    public function offer_details(string $id)
    {
        $offer_id = $id;
        $offer = Offer::find($offer_id);
        return view('backend/offer/offer-details', compact('offer'));
        
    }


    public function getGiftsData($offer_id)
    {
        $data = Gift::latest()->where('offer_id', $offer_id)->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("images")."/".$name.'">';
                    return $icon;
                })
                ->addColumn('image', function($row){
                    $file = $row->banner;
                    $glob = '<img src="'.asset("offer")."/".$file.'" style="width:40px"">';
                    return $glob;
                })
                ->addColumn('details', function($row){
                    return $row->specification;
                })
                ->editColumn('updated_at', function($row){ 
                    return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                 }) 
                ->addColumn('action', function($row){

                    // $btn = ' <abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'"data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a></abbr>';

                    $btn = ' <abbr title="Change Status"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a></abbr>';

                    return $btn;
                })
                ->rawColumns(['status','image' ,'action'])
                ->make(true);
    }



    public function generate_codes(Request $request)
    {
        $products=Product::pluck('name','id')->toarray(); 
        return view('backend/offer/generate-codes', compact('products'));
    }


}
