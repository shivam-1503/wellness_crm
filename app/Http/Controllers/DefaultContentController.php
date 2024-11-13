<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DefaultContent;
use App\Models\User;
use DataTables;
use Auth;
use DB;


class DefaultContentController extends Controller
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
        return view('pages.defaults.default_contents');
    }


    public function getDefaultContentsData()
    {
        $data = DefaultContent::latest()->get(); 
        
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

                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-info btn-sm viewProduct"><i class="fa fa-eye"></i></a>';

                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a>';

                        return $btn;
                })
                ->rawColumns(['status', 'action'])
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
        $this->validate($request,[
            'content' => 'required',
            'status' => 'required'
        ],
        [
            'content.required' => 'Content is required.',
            'status.required' => 'Status is required.',
        ]);

        $res = DefaultContent::updateOrCreate(
                            ['id' => $request->content_id],
                            [  
                                'company_id'=>Auth::user()->company_id,
                                'content'=>$request->content,
                                'status'=>$request->status,
                                'description'=>$request->description,
                            ]
                        ); 


        // if($request->ajax()){
        //     $customers = Project::where('status', '=', 1)->select("id", DB::raw("CONCAT(customers.first_name,' ',customers.last_name,' - ',customers.company) as full_name"))->orderBy('customers.first_name')->pluck('full_name', 'id')->toArray();
        //     return response()->json($customers); 
        // }



        if($res){
            $msg = $request->content_id ? "Great! Content Updated Successfully." : "Great! Content Added Successfully." ;
        }
        else{
            $msg = "Sorry! There might be some error. Please try again.";
        }
        return response()->json(['msg'=>$msg]);
    
    }


    public function details(Request $request, $id)
    {
        $details = DefaultContent::where('id', $id)->get()->first();
        if($request->ajax()){
            return response()->json($details); 
        }
        return false;
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $content = DefaultContent::find($id);
        return response()->json($content);
    }



    public function destroy($id)
    {
        $del = DefaultContent::find($id)->delete();
        return response()->json(['success'=>'Project deleted successfully.']);
    }



}
