<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpi;
use App\Models\KpiGroup;
use DataTables;
use Auth;


class KpiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('permission:list-services|create-service|update-service|delete-service', ['only' => ['index','store']]);
        // $this->middleware('permission:create-service', ['only' => ['create','store']]);
        // $this->middleware('permission:update-service', ['only' => ['edit','update']]);
        // $this->middleware('permission:delete-service', ['only' => ['destroy']]);
    }


    public function units() 
    {
        return ['INR'=>'INR', 'Percentage'=>'Percentage', 'Number'=>'Number'];
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $groups = KpiGroup::where('status', 1)->pluck('title', 'id')->toArray();
        $units = $this->units();
        return view('pages.assessment.kpis', compact('groups', 'units'));
    }


    public function getKpisData()
    {
        $data = Kpi::latest()->with(['group'])->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("backend_assets/images")."/".$name.'">';
                    return $icon;
                })
                ->addColumn('group', function($row){
                    $name = $row->group ? $row->group->title : '';
                    return $name;
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
        
        Kpi::updateOrCreate(
                                    ['id' => $request->kpi_id],
                                    [
                                        'company_id'=>Auth::user()->company_id,
                                        'title' => ucwords($request->title), 
                                        'kpi_group_id' => $request->kpi_group_id, 
                                        'description' => $request->description, 
                                        'unit' => $request->unit, 
                                        'status'=>$request->status,
                                    ]
                                );        
        if($request->kpi_id){
            $msg = "KPI Updated Successfully.";
        }
        else{
            $msg = "KPI Created Successfully.";
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
        $cats = Kpi::find($id);
        return response()->json($cats);
    }


    public function destroy($id)
    {
        $del = Kpi::find($id)->delete();
        return response()->json(['success'=>'KPI deleted successfully.']);
    }



}
