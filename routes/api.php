<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\MasterController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\CatalogueController;
use App\Http\Controllers\Api\LeadsController;
use App\Http\Controllers\Api\RefundController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\RestController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });




Route::group([
    'middleware' => ['api'],
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);


    Route::post('login_with_mobile', [AuthController::class, 'login_with_mobile']);
    Route::post('verify_otp', [AuthController::class, 'verify_otp']);
});



Route::group([
    'middleware' => ['jwt.verifyyyy'],
], function ($router) {
    Route::get('/v2/get_dashboard', [DashboardController::class, 'get_dashboard']);
});


// Route::group(function ($router) {
//     Route::middleware(['api','jwt.verify'])->get('/v2/get_dashboard', [DashboardController::class, 'get_dashboard']);
// });





Route::controller(MasterController::class)->group(function () {
    Route::post('/v2/shikhar', 'index');
    Route::get('/v2/get_business_details', 'get_business_details');
    Route::get('/v2/get_projects', 'get_projects');
    Route::get('/v2/get_featured_projects', 'get_projects');
    Route::get('/v2/get_testimonials_list', 'getTestimonialsList');
    Route::get('/v2/get_employee_list', 'getEmployeesList');
    Route::get('/v2/get_project_details/{id}', 'get_project_details');
});


Route::controller(LeadsController::class)->group(function(){
    Route::post('/v2/create_new_leads','create_new_leads');
    Route::get('/v2/leads_list','leads_list');
    Route::get('/v2/lead_detail/{id}','lead_detail');
    Route::get('/v2/lead_details/{id}','lead_details');
    Route::get('/v2/lead_stages','lead_stages');
    Route::get('/v2/lead_sources','lead_sources');
    Route::post('/v2/store_call','store_call');
    Route::post('/v2/store_waiting','store_waiting');
    Route::post('/v2/store_meeting','store_meeting');
    Route::post('/v2/store_comment','store_comment');
    Route::get('/v2/get_comments','get_comments');
    Route::get('/v2/get_services','get_services');
    Route::post('/v2/store_task_response/{id}','store_task_response');
});


Route::controller(RefundController::class)->group(function(){
    Route::post('/v2/request_reimbursement','request_reimbursement');
    Route::get('/v2/reimbursement_details/{id}','reimbursement_details');
    Route::get('/v2/reimbursement_list','reimbursement_list');
});

Route::controller(DashboardController::class)->group(function(){
    Route::get('/v2/get_dashboard','get_dashboard');
    Route::get('/v2/get_task','get_task');
    Route::get('/v2/get_top_tasks','get_top_tasks');
    Route::get('/v2/get_today_task','get_today_task');
    Route::get('/v2/get_meeting_graph','get_meeting_graph');
    Route::get('/v2/get_revenue_target','get_revenue_target');
    Route::get('/v2/get_sales','get_sales');
});

Route::controller(CatalogueController::class)->group(function(){
    Route::get('/v2/get_category','get_category');
    Route::get('/v2/get_product_details/{id}','get_product_details');
    Route::get('/v2/get_products','get_products');
});

Route::controller(RestController::class)->group(function(){
    Route::get('/v2/get_tasks','get_tasks');
    Route::post('/v2/add_event','add_event');
    Route::post('/v2/edit_event/{id}','edit_event');
    Route::get('/v2/delete_event/{id}','delete_event');
});

Route::middleware('auth:sanctum')->post('/day-start', [AttendanceController::class, 'day_start']);
