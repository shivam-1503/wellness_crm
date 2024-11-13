<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use DataTables;
use Auth;


class DesignationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('permission:list-designations|create-designation|update-designation|delete-designation', ['only' => ['index','store']]);
        // $this->middleware('permission:create-designation', ['only' => ['create','store']]);
        // $this->middleware('permission:update-designation', ['only' => ['edit','update']]);
        // $this->middleware('permission:delete-designation', ['only' => ['destroy']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.master.designations');
    }


    public function getDesignationsData()
    {
        $data = Designation::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("images")."/".$name.'">';
                    return $icon;
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){

                    $btn = '';

                    if(Auth::user()->can('update-designation')) {
                       $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a>';
                    }
                    if(Auth::user()->can('delete-designation')) {
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
        $this->validate($request, ['title'=>'required', 'status'=>'required']); 
        
        Designation::updateOrCreate(
                                    ['id' => $request->designation_id],
                                    [
                                        'company_id'=>Auth::user()->company_id,
                                        'title' => ucwords($request->title), 
                                        'description' => $request->description, 
                                        'status'=>$request->status,
                                    ]
                                );        
        if($request->designation_id){
            $msg = "Designation Updated Successfully.";
        }
        else{
            $msg = "Designation Created Successfully.";
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
        $cats = Designation::find($id);
        return response()->json($cats);
    }


    public function destroy($id)
    {
        $del = Designation::find($id)->delete();
        return response()->json(['success'=>'Designation deleted successfully.']);
    }



}
