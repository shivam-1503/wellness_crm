<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docter;
use App\Models\Speciality;
use DataTables;
use Auth;


class DocterController extends Controller
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
        
        $speciality = Speciality::where('status', 1)->pluck('title', 'id')->toArray();

        return view('pages.docter.docters', compact('speciality'));
    }


    public function getDoctersData()
    {
        $data = Docter::latest()->get(); 
        
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

                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a>';

                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';

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
        $this->validate($request, ['name'=>'required', 'status'=>'required']); 
        
        Docter::updateOrCreate(
                                    ['id' => $request->docter_id],
                                    [
                                        'name' => ucwords($request->name), 
                                        'speciality_id'=>$request->speciality_id,
                                        'DOB' => ucwords($request->DOB),
                                        'email' => ucwords($request->email),
                                        'phone' => ucwords($request->phone), 
                                        'experience' => ucwords($request->experience), 
                                        'status'=>$request->status,
                                    ]
                                );        
        if($request->docter_id){
            $msg = "Docter Updated Successfully.";
        }
        else{
            $msg = "Docter Created Successfully.";
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
        $docs = Docter::find($id);
        return response()->json($docs);
    }


    public function destroy($id)
    {
        $del = Docter::find($id)->delete();
        return response()->json(['success'=>'Docter deleted successfully.']);
    }

}
