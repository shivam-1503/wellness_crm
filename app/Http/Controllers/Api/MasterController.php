<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;
use App\Models\State;
use App\Models\Business;
use App\Models\BusinessSocial;
use App\Models\Testimonial;
use App\Models\Employee;

use App\Models\Project;
use App\Models\PropertyType;
use App\Models\Property;
use App\Models\Amenity;
use App\Models\ProjectAmenity;
use App\Models\ProjectImage;
use App\Models\Task;

use DB;

     

class MasterController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse("Hello","World!");
    }

    private function get_uuid()
    {
        // $business = Business::where('company_id', Auth::user()->company_id)->first();
        // return $business->uuid;

        return "f6a97358c202f4d96f839aa83884cf3f736c72f2";
    }

    
    public function get_business_details()
    {
        $uuid = $this->get_uuid();

        if($uuid) {
            $data['basic'] = Business::where('uuid', $uuid)->first();
            $data['social'] = BusinessSocial::where('uuid', $uuid)->first();
            $data['state'] = State::find($data['basic']->state_id);
        }
        else {
            $data = null;
        }

        return $this->sendResponse($data, 'Business Details Fetched sucessfully');
    }


    public function get_projects()
    {
        $data = Project::latest()->where('status', 1)->where('property_exists', 1)->select('id', 'title', 'description', 'state_id', 'city', 'address', 'pincode', 'rera', 'thumb_image')->get();
        return $this->sendResponse($data, 'Business Details Fetched sucessfully');
    }


    public function get_project_details($id)
    {
        $project_id = $id;

        $project = Project::find($project_id);

        if($project) {
            $properties = Property::where('status', 1)->where('project_id', $project_id)->get();

            $project_images = ProjectImage::where('project_id', $project_id)->whereNull('property_id')->get();
            $amenities = ProjectAmenity::with('amenity')->where('project_id', $project_id)->get();
            
            $project->properties = $properties;
            $project->images = $project_images;
            $project->amenities = $amenities;
        }

        return $this->sendResponse($project, 'Project Details Fetched sucessfully!');
    }
  



    
	 /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTestimonialsList()
    {
        $data = Testimonial::where('status', 1)->select('id', 'name', 'city', 'description', 'rating', 'image')->get();

        if ($data) {
            return $this->sendResponse($data, 'Categories Found Successfully');
        } else {
            return $this->sendError($data, 'Categories Not Found');
        }
    }



    	 /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmployeesList()
    {
        $data = Employee::where('status', 1)->with('designation:id,title')->orderBy('display_order', 'ASC')->get();

        if ($data) {
            return $this->sendResponse($data, 'Categories Found Successfully');
        } else {
            return $this->sendError($data, 'Categories Not Found');
        }
    }




    // COURSE API
    public function getCoursesData()
    {
      $data= DB::table('courses')
                ->leftJoin('course_categories', 'courses.category', '=', 'course_categories.id')
                ->where('courses.status',1)
                ->select('courses.*','course_categories.title')
                ->get()
                ->toArray();

      return $this->sendResponse($data, 'Course Published sucessfully');
    }

    public function get_tasks()
    {
        $task = Task::with(['user:name,id'])->whereNotNull('user_id')->select('id', 'title', 'user_id', 'type', 'start_date', 'end_date', 'lead_id', 'description', 'attendee', 'meeting_link', 'priority', 'status', 'response_status', 'response_remarks')->get();

        if($task){ 
            return $this->sendResponse($task, 'Here is the given task');
        }

        else{
            return $this->sendError(false);
        }
    }

}