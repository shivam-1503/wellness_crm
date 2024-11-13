<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyType;
use App\Models\State;
use App\Models\Business;
use App\Models\BusinessSocial;
use App\Models\BusinessSms;
use App\Models\BusinessEmail;

use Auth;


class BusinessController extends Controller
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
    
    
    
    // BASIC Settings Starts Here:
    public function basic_details()
    {
        $states = State::where('status', 1)->pluck('name', 'id')->toArray();
        $uuid = $this->get_uuid();

        if($uuid) {
            $business = Business::where('uuid', $uuid)->first();

            $data = Business::find($business->id);   
        }
        else {
            $data = null;
        }
        return view('pages.business.basic_details', compact('states', 'data'));
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit_basic_details(Request $request)
    {
        $uuid = $this->get_uuid();

        if($uuid) {
            $business = Business::where('uuid', $uuid)->first();

            $data = Business::find($business->id);   
        }
        else {
            $data = null;
        }

        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_basic_details(Request $request)
    {
        $this->validate($request,[
            'full_name' => 'required',
            'name' => 'required',
            'state_id' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ],
        [
            'full_name.required' => 'Business Full Name is required.',
            'name.required' => 'Business Name is required.',
            'state_id.required' => 'State is required.',
            'city.required' => 'City is required.',
            'pincode.required' => 'Pincode is required.',
            'pincode.numeric' => 'Pincode must be numeric.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid Email. Please enter valid email id.',
            'phone.required' => 'Phone is required.',
            'phone.numeric' => 'Phone must be numeric.',
        ]);
        
        $uuid = $this->get_uuid();

        if($uuid) {
            $business = Business::where('uuid', $uuid)->first();

            $obj = Business::find($business->id);
            $obj->full_name = ucwords(strtolower($request->full_name));
            $obj->name = ucwords(strtolower($request->name));
            $obj->established_in = $request->established_in;
            $obj->state_id = $request->state_id;
            $obj->address = $request->address;
            $obj->city = ucwords(strtolower($request->city));
            $obj->pincode = $request->pincode;
            $obj->landline = $request->landline;
            $obj->fax = $request->fax;
            $obj->email = strtolower($request->email);
            $obj->phone = $request->phone;
            $obj->created_by = Auth::user()->id;
            
            if($obj->save()) {
                $msg = " Basic Details Updated Successfully.";
            }
            else {
                $msg = "There might be some issue. Please try again later.";
            }
        }
        else {
            $msg = "Business does not exist.";
        }

        return response()->json(['msg'=>$msg]);
    }



    // SOCOAL Settings Starts Here:
    public function social_details()
    {
        $uuid = $this->get_uuid();

        if($uuid) {
            $business = BusinessSocial::where('uuid', $uuid)->first();

            $data = BusinessSocial::find($business->id);   
        }
        else {
            $data = null;
        }
        return view('pages.business.social_details', compact('data'));
    }



    public function edit_social_details(Request $request)
    {
        $uuid = $this->get_uuid();

        if($uuid) {
            $business = BusinessSocial::where('uuid', $uuid)->first();

            $data = BusinessSocial::find($business->id);   
        }
        else {
            $data = null;
        }

        return response()->json($data);
    }


    


    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_social_details(Request $request)
    {
        $this->validate($request,[
            'facebook' => 'url',
            'instagram' => 'url',
        ]);
        
        $uuid = $this->get_uuid();

        if($uuid) {
            $business = BusinessSocial::where('uuid', $uuid)->first();

            $obj = BusinessSocial::find($business->id);
            $obj->facebook = $request->facebook;
            $obj->google_plus = $request->google_plus;
            $obj->instagram = $request->instagram;
            $obj->linkedin = $request->linkedin;
            $obj->youtube = $request->youtube;
            $obj->google_business = $request->google_business;
            $obj->twitter = $request->twitter;
            $obj->created_by = Auth::user()->id;
            
            if($obj->save()) {
                $msg = "Social Details Updated Successfully.";
            }
            else {
                $msg = "There might be some issue. Please try again later.";
            }
        }
        else {
            $msg = "Business does not exist.";
        }

        return response()->json(['msg'=>$msg]);
    }





    // SMS Settings Starts here:
    public function sms_details()
    {
        $uuid = $this->get_uuid();

        if($uuid) {
            $business = BusinessSms::where('uuid', $uuid)->first();

            $data = BusinessSms::find($business->id);   
        }
        else {
            $data = null;
        }
        return view('pages.business.sms_details', compact('data'));
    }



    public function edit_sms_details(Request $request)
    {
        $uuid = $this->get_uuid();

        if($uuid) {
            $business = BusinessSms::where('uuid', $uuid)->first();

            $data = BusinessSms::find($business->id);   
        }
        else {
            $data = null;
        }

        return response()->json($data);
    }


    


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_sms_details(Request $request)
    {
        $this->validate($request,[
            'endpoint' => 'required|url',
            'sender_name' => 'required',
        ],
        [
            'endpoint.required' => 'Host Endpoint is Required.',
            'endpoint.url' => 'Please Enter Valid Host Endpoint.',
            'sender_name.required' => 'Sender Name is Required.',
        ]);
        
        $uuid = $this->get_uuid();

        if($uuid) {
            $business = BusinessSms::where('uuid', $uuid)->first();

            $obj = BusinessSms::find($business->id);
            $obj->endpoint = strtolower($request->endpoint);
            $obj->username = $request->username;
            $obj->password = $request->password;
            $obj->bearer_token = $request->bearer_token;
            $obj->sender_name = strtoupper($request->sender_name);
            
            if($obj->save()) {
                $msg = "SMS Details Updated Successfully.";
            }
            else {
                $msg = "There might be some issue. Please try again later.";
            }
        }
        else {
            $msg = "Business does not exist.";
        }

        return response()->json(['msg'=>$msg]);
    }





    // EMAIL Settings Starts here:
    public function email_details()
    {
        $uuid = $this->get_uuid();

        if($uuid) {
            $business = BusinessEmail::where('uuid', $uuid)->first();

            $data = BusinessEmail::find($business->id);   
        }
        else {
            $data = null;
        }
        return view('pages.business.email_details', compact('data'));
    }



    public function edit_email_details(Request $request)
    {
        $uuid = $this->get_uuid();

        if($uuid) {
            $business = BusinessEmail::where('uuid', $uuid)->first();

            $data = BusinessEmail::find($business->id);   
        }
        else {
            $data = null;
        }

        return response()->json($data);
    }


    


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_Email_details(Request $request)
    {
        $this->validate($request,[
            'email_id' => 'required|email',
            'password' => 'required',
            'security_type' => 'required',
            'port' => 'required|numeric',
        ],
        [
            'email_id.required' => 'Email Id is Required.',
            'email_id.email' => 'Please Enter Valid Email Id.',
            'password.required' => 'Password is Required.',
            'security_type.required' => 'Security Type is Required.',
            'port.required' => 'Port is Required.',
            'port.numeric' => 'Port must be numeric.',
        ]);
        
        $uuid = $this->get_uuid();

        if($uuid) {
            $business = BusinessEmail::where('uuid', $uuid)->first();

            $obj = BusinessEmail::find($business->id);
            $obj->email_id = strtolower($request->email_id);
            $obj->display_name = ucwords(strtolower($request->display_name));
            $obj->host = $request->host;
            $obj->password = $request->password;
            $obj->security_type = $request->security_type;
            $obj->port = $request->port;
            
            if($obj->save()) {
                $msg = "Email Details Updated Successfully.";
            }
            else {
                $msg = "There might be some issue. Please try again later.";
            }
        }
        else {
            $msg = "Business does not exist.";
        }

        return response()->json(['msg'=>$msg]);
    }





    private function get_uuid()
    {
        $business = Business::where('company_id', Auth::user()->company_id)->first();
        return $business->uuid;
    }

    


    public function destroy($id)
    {
        $del = PropertyType::find($id)->delete();
        return response()->json(['success'=>'Property Type deleted successfully.']);
    }



}
