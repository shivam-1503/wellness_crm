<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Docter;
use DataTables;
use Auth;


class PatientController extends Controller
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
        
        $docters = Docter::where('status', 1)->pluck('name', 'id')->toArray();

        return view('pages.patient.patients', compact('docters'));
    }


    public function getPatientsData()
    {
        $data = Patient::latest()->get(); 
        
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
        $this->validate($request, ['name'=>'required', 'phone'=>'required', 'status'=>'required']); 
        
        Patient::updateOrCreate(
                                    ['id' => $request->patient_id],
                                    [
                                        'name' => ucwords($request->name), 
                                        'phone' => ucwords($request->phone),
                                        'docter_id'=>$request->docter_id,
                                        'address' => ucwords($request->address), 
                                        'email' => ucwords($request->email), 
                                        'DOB' => ucwords($request->DOB), 
                                        'status'=>$request->status,
                                    ]
                                );        
        if($request->patient_id){
            $msg = "Patient Updated Successfully.";
        }
        else{
            $msg = "Patient Created Successfully.";
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
        $patient = Patient::find($id);
        return response()->json($patient);
    }


    public function destroy($id)
    {
        $del = Patient::find($id)->delete();
        return response()->json(['success'=>'Patient deleted successfully.']);
    }

}
