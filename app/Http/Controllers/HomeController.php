<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Lead;
use App\Models\LeadStage;
use App\Models\Employee;
use App\Models\Notice;
use App\Models\CustomerPayment;
use App\Models\Order;
use Spatie\GoogleCalendar\Event;
use Auth;
use Session;

class HomeController extends Controller
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
        $user_id = Auth::user()->id;
        
        $employee = Employee::where('user_id', $user_id)->get()->first();

        $emp_stats = $employee ? $this->employee_stats($user_id) : [];

        // Notifications
        $tasks = Task::where('response_status', 0)->select('type', 'title', 'start_date')->get();
        Session::put('notifications', $tasks);

         // Notice
         $notice = Notice::latest()->get()->first(); 

        // Lead Counts as per stages
        $stages = LeadStage::where('status', 1)->select('id','name', 'icon')->get();

        foreach($stages as &$obj) {
            $count = Lead::where('stage_id_fk', $obj->id)->get()->count();
            $obj->lead_count = $count;
        }

        return view('dashboard', compact('tasks', 'stages', 'notice', 'emp_stats'));
    }



    private function employee_stats($id)
    {
        $employee = Employee::where('user_id', $id)->get()->first();

        $current_month_revenue = [
            'title' => 'Revenue',
            'data' => $this->get_this_month_revenue($id),
            'icon' => 'fa fa-file-invoice-dollar',
        ];

        
        $current_month_orders = [
            'title' => 'Orders Finalized',
            'data' => $this->get_this_month_orders($id),
            'icon' => 'fa fa-shopping-cart',
        ];

        $current_month_prospects = [
            'title' => 'New Prospects',
            'data' => $this->get_this_month_prospects($id),
            'icon' => 'fa fa-user',
        ];

        $currnt_month_p_to_c_ratio = [
            'title' => 'Conversion Rate',
            'data' => $this->get_this_month_p_to_c_ratio($id).'%',
            'icon' => 'fa fa-percentage',
        ];
        
        
        $current_month_meetings = [
            'title' => 'Meetings Assigned',
            'data' => $this->get_this_month_meetings($id),
            'icon' => 'fa fa-paperclip',
        ];
        
        
        $current_month_meetings_done = [
            'title' => 'Meetings Done',
            'data' => $this->get_this_month_meetings_done($id),
            'icon' => 'fa fa-handshake',
        ];

        $data = [];
        
        if($employee->kpi_group == 1) {
            $data['revenue'] = $current_month_revenue;
            $data['orders'] = $current_month_orders;
            $data['p_to_c_ratio'] = $currnt_month_p_to_c_ratio;
        }
        elseif ($employee->kpi_group == 2) {
            $data['revenue'] = $current_month_revenue;
            $data['orders'] = $current_month_orders;
            $data['p_to_c_ratio'] = $currnt_month_p_to_c_ratio;
            $data['prospects'] = $current_month_prospects;
            $data['meetings'] = $current_month_meetings;
            $data['meetings_done'] = $current_month_meetings_done;
        }
        elseif ($employee->kpi_group == 3) {
            $data['prospects'] = $current_month_prospects;
            $data['meetings'] = $current_month_meetings;
        }

        return $data;
    }


    private function get_this_month_revenue($id)
    {
        $data = CustomerPayment::where('payment_date', 'LIKE', date('Y-m').'%')->where('status', 1)->sum('amount_paid');
        return $data;
    }



    private function get_this_month_orders($id)
    {
        $data = Order::where('created_at', 'LIKE', date('Y-m').'%')->where('status', 1)->get()->count();
        return $data;
    }


    private function get_this_month_prospects($id)
    {
        $data = Lead::where('prospecting_at', 'LIKE', date('Y-m').'%')->where('prospecting_status', 1)->get()->count();
        return $data;
    }


    private function get_this_month_p_to_c_ratio($id)
    {
        $prospects = Lead::where('prospecting_at', 'LIKE', date('Y-m').'%')->where('prospecting_status', 1)->select('id')->get();

        $orders = Order::whereIn('lead_id', $prospects)->get()->count();

        return $orders != 0 ?  ($orders * 100) / $orders : 0;
    }


    private function get_this_month_meetings($id)
    {
        $data = Task::where('user_id', $id)->where('start_date', 'LIKE', date('Y-m').'%')->get()->count();
        return $data;
    }


    private function get_this_month_meetings_done($id)
    {
        $data = Task::where('user_id', $id)->where('start_date', 'LIKE', date('Y-m').'%')->where('response_status', 1)->get()->count();
        return $data;
    }






    public function getStats()
    {
        // Notifications
        $tasks = Task::where('response_status', 0)->select('type', 'title', 'start_date')->get();
        Session::put('notifications', $tasks);


        // Lead Counts as per stages
        $stages = LeadStage::where('status', 1)->select('id','name')->get();

        $leads = [];
        $names = [];
        foreach($stages as &$obj) {
            $count = Lead::where('stage_id_fk', $obj->id)->get()->count();
            $obj->lead_count = $count;
            array_push($leads, $count);

            // $leads[$obj->name] = $count;
            array_push($names, $obj->name);

        }

        return response()->json(['leads'=>$leads, 'names'=>$names]);

    }

}



