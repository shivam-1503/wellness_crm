<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyType;
use App\Models\State;
use Auth;


class CompanyController extends Controller
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
        
        return view('pages.property_types.property_types');
    }


    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $states = State::where('status', '=', 1)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        return view('pages.company.company_edit', compact('states'));
    }



        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_basic_details(Request $request)
    {
        // $this->validate($request, ['name'=>'required', 'status'=>'required']); 
        
        dd($request);
        
        $msg = " Basic Details Updated Successfully.";
        return response()->json(['msg'=>$msg]);
    }



    


    public function destroy($id)
    {
        $del = PropertyType::find($id)->delete();
        return response()->json(['success'=>'Property Type deleted successfully.']);
    }



}
