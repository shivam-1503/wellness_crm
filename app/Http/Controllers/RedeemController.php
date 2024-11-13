<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RedeemRequest;


use DataTables;
use Auth;
use DB;

class RedeemController extends Controller
{

    // The notes are required i the celebs of what i seek most. but i do not know for the terms.

    // function __construct()
    // {
    //      $this->middleware('permission:general-list|general-create|general-edit|general-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:general-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:general-sidebar');
    //      $this->middleware('permission:general-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:general-delete', ['only' => ['delete']]);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        return view('backend/redeem-request/request-list');
    }



    public function getRedeemRequestsData()
    {
        $data = RedeemRequest::latest()->get(); 

        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('phone', function ($row) {
                    return $row->user->phone;
                })
                ->addColumn('offer', function ($row) {
                    return $row->offer->offer_title;
                })
                ->addColumn('gift', function ($row) {
                    return $row->gift->title;
                })
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("images")."/".$name.'">';
                    return $icon;
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){

                       $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-secondary btn-sm editProduct"><i class="fa fa-eye"></i></a></abbr>';

                        return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
    }



    public function update_request_status(Request $request) 
    {

        // Validate Process Redeem Request



        // Transaction Initiated
        DB::beginTransaction();

        try {
            $object = RedeemRequest::find($request->request_id);

            if ($object) {

                $object->status = $request->status;
                $object->remarks = $request->remarks;
                
                if($object->save()) {
                    // Update the status debit transaction against this request



                
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            // throw $e;
            return response()->json(['success' => false, 'msg' => $e]);
        }

        DB::commit();
        return response()->json(['success' => true, 'msg' => 'Request Processed Successfully!']);


    }



}