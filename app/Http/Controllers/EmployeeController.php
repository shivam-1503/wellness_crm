<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Employee;
use App\Models\User;
use App\Models\Designation;
use App\Models\Company;
use Spatie\Permission\Models\Role;
use DataTables;
use Auth;
use DB;
use Hash;
use File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('permission:list-employees|create-employee|update-employee|delete-employee', ['only' => ['index','store']]);
        // $this->middleware('permission:create-employee', ['only' => ['create','store']]);
        // $this->middleware('permission:update-employee', ['only' => ['edit','update']]);
        // $this->middleware('permission:delete-employee', ['only' => ['destroy']]);
        
        // $this->middleware('permission:employee-profile', ['only' => ['details']]);
        // $this->middleware('permission:manage-employee-access', ['only' => ['grant_system_access','suspend_system_access']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.employee.employees');
    }


    public function getEmployeesData()
    {
        $data = Employee::latest()->with('designation')->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("backend_assets/images")."/".$name.'">';
                    return $icon;
                })
                ->editColumn('designation', function($row){ 
                        return $row->designation->title;                     
                     }) 
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){

                    $btn = '';

                    if(Auth::user()->can('employee-profile')) {
                       $btn = '<a href='.url('employee/details/'.$row->id).' title="Details" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>';
                    }

                    if(Auth::user()->can('update-employee')) {
                       $btn = $btn.' <a href='.url('employee/edit/'.$row->id).' title="Edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';
                    }

                    if(Auth::user()->can('manage-employee-access')) {
                       if($row->has_access == 0) {
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-access="'.$row->has_access.'" data-original-title="Create User Access" class="btn btn-warning btn-sm suspendAccess"><i class="fa fa-user"></i></a>';
                       }
                       else {
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-access="'.$row->has_access.'" data-original-title="Delete User Access" class="btn btn-success btn-sm suspendAccess"><i class="fa fa-user"></i></a>';
                       }
                    }

                    if(Auth::user()->can('delete-employee')) {
                       $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete Employee" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['country','status', 'action'])
                ->make(true);
    }



    public function create($cat_id=false)
    {
        $states = State::where('status', '=', 1)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $designations = Designation::where('status', '=', 1)->pluck('title', 'id')->toArray();

        $roles = Role::pluck('name','name')->all();

        $employees = Employee::with('designation')->where('status', 1)->get();

        $reporting_managers = [];
        foreach($employees as $employee) {
            $designation = $employee->designation ? $employee->designation->title : 'NULL';
            $reporting_managers[$employee->id] = $employee->name.' - '.$designation;
        }

        return view('pages.employee.employee_add', compact('states', 'designations', 'reporting_managers', 'roles'));
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
            'name' => 'required',
            'phone' => 'required|numeric',
            'status' => 'required',
        ],
        [
            'name.required' => 'Name is required.',
            'phone.required' => 'Phone No is required.',
            'phone.numeric' => 'Phone No must be numeric.',
            'status.required' => 'Status is required.',
        ]);

        if(isset($request->employee_id)){
            $this->validate($request, [
              'phone' => 'unique:App\Models\Employee,phone,'.$request->employee_id,
            ]);
        }
        else{
            $this->validate($request,[
              'phone' => 'unique:employees,phone',
            ]);
        }

        $res = Employee::updateOrCreate(
                            ['id' => $request->employee_id],
                            [  
                                'company_id'=>Auth::user()->company_id,
                                'account_manager_id'=>$request->account_manager_id,
                                'designation_id'=>$request->designation_id,
                                'reporting_manager_id'=>$request->reporting_manager_id,
                                'name' => ucwords($request->name), 
                                'gender' => $request->gender,
                                'dob'=>$request->dob, 
                                'uidai'=>$request->uidai, 
                                'pan'=>$request->pan, 
                                'email'=>$request->email,
                                'phone'=>$request->phone,
                                'state_id'=>$request->state_id,
                                'city'=>ucwords($request->city),
                                'address'=>$request->address,
                                'pincode'=>$request->pincode,
                                'joining_date'=>date('Y-m-d', strtotime($request->joining_date)),
                                'experience'=>$request->experience,
                                'status'=>$request->status,
                            ]
                        ); 


        // if($request->ajax()){
        //     $employees = Employee::where('status', '=', 1)->select("id", DB::raw("CONCAT(employees.first_name,' ',employees.last_name,' - ',employees.company) as full_name"))->orderBy('employees.first_name')->pluck('full_name', 'id')->toArray();
        //     return response()->json($employees); 
        // }

        if(!$request->employee_id) {

            $pwd = 123456;
            $password = Hash::make($pwd);

            $obj['name'] = $res->name;
            $obj['email'] = $res->email;
            $obj['phone'] = $res->phone;
            $obj['password'] = $password;

            $user = User::create($obj);
            $user->assignRole($request->roles);


            $emp_no = Employee::select('employee_no')->orderBy('employee_no', 'DESC')->get()->first();
            $company = Company::find(Auth::user()->company_id);
            $employee_no = $emp_no->employee_no + 1;
            $employee_code = $company->employee_prefix.'-'.sprintf("%04d", $employee_no);;

            $emp = Employee::find($res->id);
            $emp->employee_no = $employee_no;
            $emp->employee_code = $employee_code;
            $emp->has_access = 1;
            $emp->user_id = $user->id;
            $emp->save();
        }


        if($res){
            $msg = $request->employee_id ? "Great! Employee Updated Successfully." : "Great! Employee Added Successfully." ;
        }
        else{
            $msg = "Sorry! There might be some error. Please try again.";
        }
        return response()->json(['msg'=>$msg]);
    
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($employee_id)
    {
        $designations = Designation::where('status', '=', 1)->pluck('title', 'id')->toArray();
        $states = State::where('status', '=', 1)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $roles = Role::pluck('name','name')->all();

        $employees = Employee::with('designation')->where('status', 1)->get();

        $reporting_managers = [];
        foreach($employees as $employee) {
            $designation = $employee->designation ? $employee->designation->title : 'NULL';
            $reporting_managers[$employee->id] = $employee->name.' - '.$designation;
        }

        return view('pages.employee.employee_add', compact('employee_id', 'designations', 'states', 'reporting_managers', 'roles'));
    }


    public function details(Request $request, $id)
    {
        $details = Employee::where('user_id', $id)->with('source')->get()->first(); 
        return view('pages.employee.employee_details', compact('details'));
    }


    public function getEmployeeDetails(Request $request, $id)
    {
        $details = Employee::where('id', $id)->with('source')->get()->first();
        return response()->json($details);
    }

    



    public function destroy($id)
    {
        $emp = Employee::find($id);

        if($emp && $emp->has_access==1) {
            $obj = User::find($emp->user_id);
            $obj->status = 4;
            if($obj->save())
            {
                $emp->has_access = 0;
                $emp->save();
            }

            $del = Employee::find($id)->delete();
        }
        else if($emp && $emp->has_access == 0){
            $del = Employee::find($id)->delete();
        }

        return response()->json(['success'=>'Employee deleted successfully.']);
    }






    public function grant_system_access(Request $request, $id)
    {

        $emp = Employee::find($id);

        if($emp) {

            if(is_null($emp->user_id)) {
                // $pwd = $input['password'];
                $pwd = 123456;
                $password = Hash::make($pwd);

                $obj['name'] = $emp->name;
                $obj['email'] = $emp->email;
                $obj['phone'] = $emp->phone;
                $obj['password'] = $password;

                $roles = [1];

                $user = User::create($obj);
                $user->assignRole($roles);


                if($user) {
                    $emp->user_id = $user->id;
                    $emp->has_access = 1;
                    $emp->save();
                }
            }
            else {
                $obj = User::find($emp->user_id);
                $obj->status = 1;
                if($obj->save())
                {
                    $emp->has_access = 1;
                    $emp->save();
                }
            }
            
        }

        return response()->json(['success'=>'Employee System Access Granted Successfully!']);
    }



    public function suspend_system_access(Request $request, $id)
    {

        $emp = Employee::find($id);

        if($emp) {

            if($emp->has_access == 0) {
                $status = 1;
                $access = 1;
            }
            else {
                $status = 4;
                $access = 0;
            }

            $obj = User::find($emp->user_id);
            $obj->status = $status;
            if($obj->save())
            {
                $emp->has_access = $access;
                $emp->save();
            }
        }

        return response()->json(['msg'=>'Employee Access Changes Implemented Successfully!']);
    }




    public function change_password(Request $request)  
    {
        $this->validate($request,[
            'employee_id' => 'required',
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ],
        [
            'current_password.required' => 'Current Password is required.',
            'new_password.required' => 'New Password is required.',
            'confirm_password.required' => 'Confirm Password is Required.',
        ]);
        
        
        $employee = Employee::find($request->employee_id);
        $user = User::find($employee->user_id);

        

        $currentPasswordStatus = Hash::check($request->current_password, $user->password);

        if($currentPasswordStatus){

            User::findOrFail($user->id)->update([
                'password' => Hash::make($request->new_password),
            ]);

            $request->session()->flash('success', 'Password Updated successfully');
            return redirect()->back()->with('msg', 'Password Updated successfully.');

        }else{
            $request->session()->flash('success', 'Current Password does not match with Old Password');
            return redirect()->back()->with('message','Current Password does not match with Old Password');
        }

    }


    public function upldate_profile_image(Request $request)
    {
        $employee_id = $request->employee_id;
        
        // $user = User::find($employee_id);

        // $project = Project::find($project_id);

        $this->validate($request, [
            'product_images' => ['required',
                        'image',
                        'mimes:jpeg,png,jpg,gif',
                        // 'dimensions:min_width=100,min_height=100,max_width=100,max_height=100',
                        'max:512'],
        ]);



        if ($request->hasfile('product_images')) {

            // $this->createDirecrotory();

            $file = $request->file('product_images');

            $extension = $file->getClientOriginalExtension();

            // $imageName = time() . '-' . $file->getClientOriginalName();
            // $imageName = time() . '-' . $project->title . '.' . $extension;
            $imageName = time() . '.' . $extension;

            // $imageName = str_replace(" ", "-", $imageName);
            
            $filePath = Storage::disk('public')->putFileAs('images/employees', $file, $imageName);

            $obj = Employee::find($employee_id);
            $obj->profile_image = $filePath;
            $obj->save();

            // Update thumb image in product table
            $user = User::find($obj->id);

            if(!is_null($user)) {
                $user->profile_image = $filePath;
                $user->save();
            }
        }
        
        $request->session()->flash('success', 'Image Uploaded successfully.');
        return redirect()->back()->with('msg', 'Image Uploaded successfully.');

    }

    
}
