<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;
use App\Models\Task;
use Carbon\Carbon;
use App\Models\LeadActivity;
use App\Models\Expanse;
use App\Models\OrderDetail;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use DB;


class DashboardController extends BaseController
{

    public function __construct()
    {
        # By default we are using here auth:api middleware
        # $this->middleware('auth:api');
        $this->user = JWTAuth::parseToken()->authenticate();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_dashboard()
    {
        $tasks = $this->my_tasks();
        $sales = $this->sale_stats();
        $revenue = $this->revenue();

        //return ['tasks'=>$tasks, 'sales'=>$sales, 'revenue'=>$revenue];
        return $this->sendResponse([$tasks,$sales,$revenue], 'Here is the dashboard');
        
    } 



    private function my_tasks()
    {
        $id = auth('api')->user()->id;

        $tasks = Task::with(['user:name,id'])->select('title', 'type', 'end_date', 'description', 'attendee', 'status')->where('created_by', $id)->orderby('created_at', 'desc')->take(5)->get();

        $total = $done = $pending = 0;
        foreach($tasks as $task) {
            $total = $total + 1;

            if($task->status == 1) {
                $done = $done + 1;
            }
            else {
                $pending = $pending +1; 
            }
        }

        $stats = [
            'title' => "My Title",
            'done' => $done,
            'pending' => $pending,
            'total' => $total,
        ];

        return ['tasks' => $tasks, 'stats' => $stats];
    }



    private function sale_stats()
    {
        $stats = [
            [
                'title'=> 'Assigned',
                'count'=> 20,
            ],
            [
                'title'=> 'Completed',
                'count'=> 5,
            ],
            [
                'title'=> 'Follow Up',
                'count'=> 10,
            ],
            [
                'title'=> 'Lost Deals',
                'count'=> 5,
            ],
        ];
                
        return $stats;
    }



    private function revenue()
    {
        $target = Expanse::sum('amount');

        $achieved = Expanse::sum('revenue');

        return ['Revenue target' => $target, 'Revenue Achieved' => $achieved];
    }



    public function get_today_task()
    {
        $id = auth('api')->user()->id;

        $today = date('Y-m-d');

        $task = Task::select('title', 'description', 'priority', 'status', 'attendee','end_date')->where('start_date', 'LIKE', $today.'%')->where('lead_id', $id)->orderby('start_date', 'desc')->get();

        if($task){
            return $this->sendResponse($task, 'Here is Todays Task');
        }
        else{
            return $this->sendError(false, 'No New Task today');
        }
    }



    public function get_revenue_target()
    {
        $id = auth('api')->user()->id;

        $target = Expanse::select('amount')->where('cat_id', $id)->sum('amount');

        if($target){
            return $this->sendResponse($target, 'Revenue target');
        }
        else{
            return $this->sendError(false);
        }
    }

    public function get_revenue_achieved()
    {
        $id = auth('api')->user()->id;

        $revenue = Expanse::sum('amount')->where('cat_id', $id)->get();  

        if($revenue){
            return $this->sendResponse($revenue,'Revenue Achieved');
        }
        else{
            return $this->sendError(false);
        }
    }

    public function get_sales()
    {
        $id = auth('api')->user()->id;

        $sales = OrderDetail::select('id', 'name', 'price', 'tax_amount', 'cost')->where('updated_by', $id)->get();

        if($sales){
            return $this->sendResponse($sales, 'Sales Details');
        }
        else{
            return $this->sendError(false);
        }
    }
}