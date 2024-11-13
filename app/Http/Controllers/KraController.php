<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kra;
use App\Models\Kpi;
use App\Models\KpiGroup;
use App\Models\Employee;
use DataTables;
use Auth;


class KraController extends Controller
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


    public function review_frequency() 
    {
        return ['Monthly'=>'Monthly', 'Quaterly'=>'Quaterly', 'Half-Yearly'=>'Half-Yearly', 'Yearly'=>'Yearly'];
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.assessment.kras');
    }


    public function getKrasData()
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


    public function create(Request $request, $id)
    {
        $employee = Employee::find($id);
        $kpis = Kpi::where('kpi_group_id', $employee->kpi_group)->get();

        foreach($kpis as &$kpi)
        {
            $data = Kra::where('employee_id', $employee->id)->where('kpi_id', $kpi->id)->get()->first();
            $kpi->kra = $data;
        }

        $review_frequencies = $this->review_frequency();
        return view('pages.assessment.kras', compact('employee', 'kpis', 'review_frequencies'));
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['target'=>'required', 'weightage'=>'required', 'review_frequency'=>'required', 'kpi_id'=>'required', 'employee_id'=>'required']); 
        
        // dd($request->all());

        $data = [
            'company_id'=>Auth::user()->company_id,
            'employee_id' => $request->employee_id,
            'kpi_id' => $request->kpi_id, 
            'target' => $request->target, 
            'weightage' => $request->weightage, 
            'review_frequency' => $request->review_frequency, 
            'status'=> 0,
        ]; 
        
        $count = Kra::where('employee_id', $request->employee_id)->where('kpi_id', $request->kpi_id)->get()->count();

        if($count == 0) {
            Kra::create($data);
        }
        else {
            Kra::where('employee_id', $request->employee_id)->where('kpi_id', $request->kpi_id)->update($data);
        }
       
        return response()->json(['msg'=>'KRA Updated Successfully!']);
    }



    public function submit_for_approval($emp_id)
    {
        $employee = Employee::find($emp_id);
        if($employee) {
            $kpis = Kpi::where('kpi_group_id', $employee->kpi_group)->get()->count();
            $data = Kra::where('employee_id', $emp_id)->where('status', 0)->get();

            if($kpis == count($data)) {
                $sum = 0;
                foreach($data as $row) {
                    $sum += $row->weightage;
                }

                if($sum == 100) {
                    $employee->kra_status = 1;
                    if($employee->save()) {
                        $success = true;
                        $msg = "KRA submitted for approval successfully!";
                    }
                    else {
                        $success = false;
                        $msg = "Please Try Again!";
                    }
                }
                else {
                    $success = false;
                    $msg = "Weighatge is not 100%. Please check and try again..";
                }
            }
            else {
                $success = false;
                $msg = "All KPIs are not recorded. Please complete all KPIs.";
            }
        }
        else {
            $success = false;
            $msg = "No Employee Found!";
        }
        return response()->json(['success'=>$success, 'msg'=>$msg]);
    }


    public function approve_kra($emp_id)
    {
        $employee = Employee::find($emp_id);
        if($employee) {
            $update = Kra::where('employee_id', $emp_id)->where('status', 0)->update(['status'=>1]);

            $employee->kra_status = 2;
            if($employee->save()) {
                $success = true;
                $msg = "KRA Approved successfully!";
            }
            else {
                $success = false;
                $msg = "Please Try Again!";
            }
        }
        else {
            $success = false;
            $msg = "No Employee Found!";
        }

        return response()->json(['success'=>$success, 'msg'=>$msg]);
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
