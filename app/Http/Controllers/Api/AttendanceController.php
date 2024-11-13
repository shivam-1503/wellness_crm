<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;

use DB;

     

class AttendanceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function day_start()
    {
        return response()->json(['message' => '! Welcome !']);
    }

    public function day_end()
    {
        return response()->json(['message' => '! Good Bye !']);
    }
   
}