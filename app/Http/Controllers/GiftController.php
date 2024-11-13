<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Auth;
use DataTables;

use App\Models\Gift;
use App\Models\Offer;

class GiftController extends Controller
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
        return view('pages/offer/gifts');
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
        $this->validate($request, ['gift_title'=>'required','image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048','points'=>'required','specification'=>'required','gift_status'=>'required']); 
        
        // return ($request->all());
        if($request->gift_id)
        {
            $data = Gift::find($request->gift_id);

            $oldImagePath = public_path("gift/{$data->image}");
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('gift'), $imageName);

        Gift::updateOrCreate(
                                    ['id' => $request->gift_id],
                                    [
                                        'title' => ucwords($request->gift_title),
                                        'specification'=>$request->specification,
                                        'points'=>$request->points,
                                        'offer_id'=>$request->giftoffer_id,
                                        'image' =>$imageName,
                                        'status'=>$request->gift_status,
                                    ]
                                );        
        if($request->Gift_id){
            $msg = "Gift Updated Successfully.";
        }
        else{
            $msg = "Gift Created Successfully.";
        }
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
        //
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
        $gift_id = $id;

        $gift = Gift::find($gift_id);
        $gift->status = 0;

        if($gift->save()) {
            return response()->json(['success' => true, 'msg' => 'Gift Status has changed successfully!']);
        }
        else {
            return response()->json(['success' => false, 'msg' => 'Error']);
        }
    }
}
