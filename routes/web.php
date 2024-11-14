<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ExpanseCategoryController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\DefaultContentController;
use App\Http\Controllers\ContentTypes;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ExpanseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ExpenseTitleController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\KraController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\influencerController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\RedeemController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DocterController;
use App\Http\Controllers\PatientController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();


// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    // Route::resource('users', UserController::class);
});



Route::group(['middleware' => ['auth']], function () {    
    Route::get('users', [UserController::class, 'index']);
    Route::get('user/edit/{id}', [UserController::class, 'edit']);
    Route::post('user/store', [UserController::class, 'store']);
    Route::post('user/update/{id}', [UserController::class, 'update']);
    Route::get('user/delete/{id}', [UserController::class, 'destroy']);
});

Route::get('/',['middleware'=>['auth'], function () {
    if(Auth::check())
    {
    	// return view('dashboard');
        return redirect('/home');
    }
    else{
    	return view('/auth/login');
    }
}]);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/getStats', [HomeController::class, 'getStats'])->name('home');



Route::controller(ServiceController::class)->group(function () {    
    Route::get('services','index');
    Route::get('getServicesData', 'getServicesData');
    Route::get('service/edit/{id}', 'edit');
    Route::post('service/store', 'store');
    Route::get('service/delete/{id}', 'destroy');
});



Route::controller(BrandController::class)->group(function () {    
    Route::get('brands','index');
    Route::get('getBrandsData', 'getBrandsData');
    Route::get('brand/edit/{id}', 'edit');
    Route::post('brand/store', 'store');
    Route::get('brand/delete/{id}', 'destroy');
});


Route::controller(DocterController::class)->group(function () {    
    Route::get('docters','index');
    Route::get('getDoctersData', 'getDoctersData');
    Route::get('docter/edit/{id}', 'edit');
    Route::post('docter/store', 'store');
    Route::get('docter/delete/{id}', 'destroy');
});


Route::controller(PatientController::class)->group(function () {    
    Route::get('patients','index');
    Route::get('getPatientsData', 'getPatientsData');
    Route::get('patient/edit/{id}', 'edit');
    Route::post('patient/store', 'store');
    Route::get('patient/delete/{id}', 'destroy');
});


Route::controller(KpiController::class)->group(function () {    
    Route::get('kpis','index');
    Route::get('getKpisData', 'getKpisData');
    Route::get('kpi/edit/{id}', 'edit');
    Route::post('kpi/store', 'store');
    Route::get('kpi/delete/{id}', 'destroy');
});


Route::controller(KraController::class)->group(function () {    
    Route::get('kras', 'index');
    Route::get('create-kra/{id}', 'create');
    Route::post('kra/store', 'store');
    Route::get('kra/submit_for_approval/{id}', 'submit_for_approval');
    Route::get('kra/approve_kra/{id}', 'approve_kra');
});



Route::controller(ExpenseTitleController::class)->group(function () {    
    Route::get('expense_titles','index');
    Route::get('getExpenseTitlesData', 'getExpenseTitlesData');
    Route::get('expense_title/edit/{id}', 'edit');
    Route::post('expense_title/store', 'store');
    Route::get('expense_title/delete/{id}', 'destroy');
});


Route::controller(ProjectController::class)->group(function () {
    Route::get('projects', 'index');
    Route::get('getProjectsData', 'getProjectsData');
    Route::get('project/create', 'create');
    Route::get('project/edit/{id}', 'edit');
    Route::get('project/manage_properties/{id}', 'manage_properties');
    Route::get('project/details/{id}', 'details');
    Route::post('project/store', 'store');
    Route::post('property/store', 'store_property');
    Route::get('getPropertiesData/{id}', 'getPropertiesData');
    Route::get('getPropertiesByProject/{project_id}/{property_type_id?}', 'getPropertiesByProject');
    Route::get('getPropertiesByProjectId/{project_id}', 'getPropertiesByProjectId');
    Route::get('property/edit/{id}', 'edit_property');
    Route::get('project/delete/{id}', 'destroy');
    Route::get('project/images/{id}/{property?}', 'project_images');
    Route::post('project/images/store', 'store_images');
    Route::get('project/image/delete/{id}', 'delete_image');
});



Route::controller(CustomerController::class)->group(function () {
    Route::get('customers', 'index');
    Route::get('getCustomersData', 'getCustomersData');
    Route::get('customer/create', 'create');
    Route::get('customer/edit/{id}', 'edit');
    Route::get('customer/details/{id}', 'details');
    Route::post('customer/store', 'store');
    Route::get('customer/delete/{id}', 'destroy');
});



Route::controller(OrderController::class)->group(function () {
    Route::get('order', 'index');
    Route::get('product/add_to_cart/{id}', 'add_to_cart');
    Route::get('product/remove-from-cart', 'remove_from_cart');
    Route::post('product/update-cart', 'update_cart');
    Route::get('order/fetch_customer/{phone}', 'fetch_customer');
    Route::post('save_order', 'save_order');
    Route::get('order/create/{id}', 'create');
    Route::post('order/get_emi', 'calculate_emi');
    Route::post('order/store', 'store_order');
    Route::post('order/get_emi_details', 'emi_details');
    Route::post('order/get_order_details', 'order_details');
    Route::get('receive_payments', 'receive_payments');
    Route::get('getCustomerOrdersData/{id}', 'get_customer_orders_data');
    Route::get('getOrderEmiDetails/{id}', 'get_order_emi_details');
    Route::post('payment/store', 'store_payment');
    Route::get('confirm_payments', 'confirm_payments');
    Route::post('getAwaitedPaymentsData', 'get_awaited_payments_data');
    Route::get('viewPaymentDetails', 'view_payment_details');
    Route::post('comfirm_payment_store', 'comfirm_payment_store');
    Route::post('reject_payment_store', 'reject_payment_store');

});




Route::controller(ReportsController::class)->group(function () {
    Route::get('payments', 'payments');
    Route::post('getPaymentsData', 'get_payments_data');
    
    Route::get('invoices', 'invoices');
    Route::post('getInvoicesData', 'get_invoices_data');

    Route::post('invoice/comment/store', 'store_invoice_comment');
    Route::post('invoice/waiting/store', 'store_invoice_waiting');
    Route::post('invoice/call/store', 'store_invoice_call');
    Route::post('invoice/meeting/store', 'store_invoice_meeting');
    
    
    
    Route::get('invoice/get_activities', 'get_all_activities');




});



Route::controller(EmployeeController::class)->group(function () {
    Route::get('employees', 'index');
    Route::get('getEmployeesData', 'getEmployeesData');
    Route::get('employee/create', 'create');
    Route::get('employee/edit/{id}', 'edit');
    Route::get('employee/details/{id}', 'details');
    Route::get('getEmployeeDetails/{id}', 'getEmployeeDetails');
    Route::post('employee/store', 'store');
    Route::get('employee/delete/{id}', 'destroy');
    Route::get('employee/grantAccess/{id}', 'grant_system_access');
    Route::get('employee/suspendAccess/{id}', 'suspend_system_access');
    Route::post('employee/change_password', 'change_password');
    Route::post('employee/upldate_profile_image', 'upldate_profile_image');
});



Route::controller(DesignationController::class)->group(function () {
    Route::get('designations', 'index');
    Route::get('getDesignationsData', 'getDesignationsData');
    Route::get('designation/create', 'create');
    Route::get('designation/edit/{id}', 'edit');
    Route::post('designation/store', 'store');
    Route::get('designation/delete/{id}', 'destroy');
});


Route::controller(NoticeController::class)->group(function () {
    Route::get('notices', 'index');
    Route::get('getNoticesData', 'getNoticesData');
    Route::get('notice/create', 'create');
    Route::get('notice/edit/{id}', 'edit');
    Route::post('notice/store', 'store');
    Route::get('notice/delete/{id}', 'destroy');
});


Route::controller(AmenityController::class)->group(function () {
    Route::get('amenities', 'index');
    Route::get('getAmenitiesData', 'getAmenitiesData');
    Route::get('amenity/create', 'create');
    Route::get('amenity/edit/{id}', 'edit');
    Route::post('amenity/store', 'store');
    Route::get('amenity/delete/{id}', 'destroy');
});


Route::controller(ExpanseCategoryController::class)->group(function () {    
    Route::get('expanse_categories','index');
    Route::get('getExpanseCategoriesData', 'getExpanseCategoriesData');
    Route::get('expanse_category/edit/{id}', 'edit');
    Route::post('expanse_category/store', 'store');
    Route::get('expanse_category/delete/{id}', 'destroy');
    Route::get('getExpenseSubCatsbyCatId/{id}', 'getExpenseSubCatsbyCatId');
});


Route::controller(ExpanseController::class)->group(function () {    
    Route::get('expanses','index');
    Route::get('getExpansesData', 'getExpansesData');
    Route::get('expanse/edit/{id}', 'edit');
    Route::post('expanse/store', 'store');
    Route::get('expanse/delete/{id}', 'destroy');

    Route::get('expanse_requests','expanse_requests');
    Route::post('getExpanseRequestsData', 'getExpanseRequestsData');
    Route::get('expanse_request/edit/{id}', 'edit_request');
    Route::post('expanse_request/store', 'store_request');
    Route::get('expanse_request/delete/{id}', 'destroy_request');
    
    Route::post('confirm_expanse_request', 'confirm_expanse_request');
    Route::post('reject_expanse_request', 'reject_expanse_request');
    
    
    Route::post('create_payment', 'create_payment');
    Route::get('expense_report', 'expense_report');
    Route::get('vendor_report', 'vendor_report');
    Route::post('getExpenseReportData', 'getExpenseReportData');
    
    Route::get('vendor/details/{id}', 'vendor_details');



});



Route::controller(VendorController::class)->group(function () {    
    Route::get('vendors','index');
    Route::get('getVendorsData', 'getVendorsData');
    Route::get('vendor/edit/{id}', 'edit');
    Route::get('vendor/deals/{id}', 'deals');
    Route::any('vendor/store', 'store');
    Route::any('vendor/categories/store', 'update_vendor_categories');
    Route::get('vendor/delete/{id}', 'destroy');
});



Route::controller(DefaultContentController::class)->group(function () {    
    Route::get('default_contents','index');
    Route::get('getDefaultContentsData', 'getDefaultContentsData');
    Route::get('default_content/edit/{id}', 'edit');
    Route::post('default_content/store', 'store');
    Route::get('default_content/delete/{id}', 'destroy');
});



Route::controller(BusinessController::class)->group(function () {      
    Route::get('my_business_details', 'index');
    Route::get('business/basic_details', 'basic_details');
    Route::get('business/edit_basic_details', 'edit_basic_details');
    Route::post('business/basic_details/store', 'update_basic_details');

    Route::get('business/social_details', 'social_details');
    Route::get('business/edit_social_details', 'edit_social_details');
    Route::post('business/social_details/store', 'update_social_details');

    Route::get('business/sms_details', 'sms_details');
    Route::get('business/edit_sms_details', 'edit_sms_details');
    Route::post('business/sms_details/store', 'update_sms_details');

    Route::get('business/email_details', 'email_details');
    Route::get('business/edit_email_details', 'edit_email_details');
    Route::post('business/email_details/store', 'update_email_details');
});


Route::get('leads/{id?}', [LeadController::class, 'index']);
Route::get('lost_leads/{id?}', [LeadController::class, 'lost_leads']);
Route::post('getleadsData', [LeadController::class, 'getLeadsData']);
Route::post('getleadsReportData', [LeadController::class, 'getLeadsReportData']);
Route::get('lead/create', [LeadController::class, 'create']);
Route::get('lead/edit/{id}', [LeadController::class, 'edit']);
Route::get('lead/getLeadData/{id}', [LeadController::class, 'getLeadData']);
Route::get('getDeadLeadsData', [LeadController::class, 'getDeadLeadsData']);
Route::post('lead/store', [LeadController::class, 'store']);
Route::get('lead/details/{id}', [LeadController::class, 'details']);
Route::get('lead/form/{lead_id}/{id}', [LeadController::class, 'lead_form']);
Route::post('lead/form-answer/store', [LeadController::class, 'store_form_data']);
Route::post('lead/comment/store', [LeadController::class, 'store_comment']);
Route::post('lead/store_comment', [LeadController::class, 'store_comment_from_list']);
Route::post('lead/sarthi/store', [LeadController::class, 'store_sarthi']);
Route::post('lead/call/store', [LeadController::class, 'store_call']);
Route::post('lead/meeting/store', [LeadController::class, 'store_meeting']);
Route::post('lead/waiting/store', [LeadController::class, 'store_waiting']);
Route::post('lead/site_visit/store', [LeadController::class, 'store_site_visit']);
Route::post('lead/review/store', [LeadController::class, 'store_review']);
Route::post('lead/assign_lead', [LeadController::class, 'assign_lead']);
Route::get('report/leads', [LeadController::class, 'leads_report']);
Route::get('lead/delete/{id}', [LeadController::class, 'destroy']);
Route::get('lead/delete/{id}', [LeadController::class, 'destroy']);
Route::get('get_lead_details/{id}', [LeadController::class, 'get_lead_details']);
Route::get('generate-lead-details', [LeadController::class, 'generateLeadDetails']);

Route::get('lead/products/{id}', [OrderController::class, 'lead_order']);
Route::get('lead_order_ajax/{id}', [OrderController::class, 'lead_order_ajax']);
Route::get('lead/quote/{id}', [OrderController::class, 'lead_quotes']);
Route::get('lead/quote/send_mail/{id}', [OrderController::class, 'send_mail']);
Route::get('generate-pdf', [OrderController::class, 'generatePDF']);
Route::get('generate-receipt', [OrderController::class, 'generateReceipt']);

Route::controller(CategoryController::class)->group(function () {      
    Route::get('categories', 'index');
    Route::get('getCategoriesData', 'getCategoriesData');
    Route::get('category/edit/{id}', 'edit');
    Route::post('category/store', 'store');
    Route::get('category/delete/{id}', 'destroy');
    Route::get('/getCategories', 'getCategories');

});


Route::controller(TaskController::class)->middleware(['auth'])->group(function () {
    Route::get('/tasks', 'index');
    Route::get('/task-calendar', 'indexFullCalendar');
    Route::post('/getTasksData', 'getTasksData');
    Route::get('/task/create', 'create');
    Route::post('/task/store', 'store');
    Route::post('/task/store_response', 'store_response');
    Route::get('/task/edit/{id}', 'edit');
    Route::post('/task/update', 'update');
    Route::get('/task/delete/{id}', 'destroy');
    Route::any('generate-tasks-report', 'generateTaskReport');
    Route::get('getTaskStats', 'getTaskStats');
});



Route::get('products', [ProductController::class, 'index']);
Route::get('getProductsData', [ProductController::class, 'getProductsData']);
Route::get('product/create/{cat_id?}', [ProductController::class, 'create']);
Route::post('product/store', [ProductController::class, 'store']);
Route::get('product/edit/{id}', [ProductController::class, 'edit']);
Route::get('product/details/{id}', [ProductController::class, 'details']);
Route::get('product/delete/{id}', [ProductController::class, 'destroy']);



Route::controller(SupportVideoController::class)->middleware(['auth'])->group(function () {
    Route::get('/support-videos', 'index');
    Route::get('/getVideosData', 'getVideosData');
    Route::post('/support_video/store', 'store');
    Route::get('/support_video/edit/{id}', 'edit');
    Route::post('/support_video/update', 'store');
    Route::get('/support_video/delete/{id}', 'destroy');
});





Route::controller(DealerController::class)->middleware(['auth'])->group(function () {
    Route::get('/dealers', 'index');
    Route::get('/getDealersData', 'getDealersData');
    Route::get('/dealer/create', 'create');
    Route::post('/dealer/store', 'store');
    Route::get('/dealer/edit/{id}', 'edit');
    Route::get('/dealer/finddistrict/{id}', 'finddistrict');
    Route::post('/dealer/update', 'update');
    Route::get('/dealer/delete/{id}', 'destroy');
});

Route::controller(OfferController::class)->middleware(['auth'])->group(function () {
    Route::get('/offers', 'index');
    Route::get('/getOffersData', 'getOffersData');
    Route::get('/offer/create', 'create');
    Route::get('/offer/details/{id}', 'offer_details');
    Route::post('/offer/store', 'store');
    Route::get('/offer/edit/{id}', 'edit');
    Route::get('/offer/finddistrict/{id}', 'finddistrict');
    Route::post('/offer/update', 'update');
    Route::get('/offer/delete/{id}', 'destroy');
    Route::get('/getGiftsData/{id?}', 'getGiftsData');
    Route::get('/generate-codes', 'generate_codes');
});

Route::controller(DistributorController::class)->middleware(['auth'])->group(function () {
    Route::get('/distributors', 'index');
    Route::get('/getDistributorsData', 'getDistributorsData');
    Route::get('/distributor/create', 'create');
    Route::post('/distributor/store', 'store');
    Route::get('/distributor/edit/{id}', 'edit');
    Route::post('/distributor/update', 'update');
    Route::get('/distributor/delete/{id}', 'destroy');
});

Route::controller(influencerController::class)->middleware(['auth'])->group(function () {
    Route::get('/influencers', 'index');
    Route::get('/getInfluencersData', 'getInfluencersData');
    Route::get('/influncer/create', 'create');
    Route::post('/influencer/store', 'store');
    Route::get('/influencer/edit/{id}', 'edit');
    Route::post('/influencer/update', 'update');
    Route::get('/influencer/delete/{id}', 'destroy');
});

Route::controller(CustomerController::class)->middleware(['auth'])->group(function () {
    Route::get('/customers', 'index');
    Route::get('/getcustomersData', 'getcustomersData');
    Route::get('/customer/create', 'create');
    Route::post('/customer/store', 'store');
    Route::get('/customer/edit/{id}', 'edit');
    Route::post('/customer/update', 'update');
    Route::get('/customer/delete/{id}', 'destroy');
});


Route::controller(KycController::class)->middleware(['auth'])->group(function () {
    Route::get('/kyc-details', 'index');
    Route::get('/getKycsData', 'getKycsData');
    Route::get('/kyc/create', 'create');
    Route::post('/kyc/store', 'store');
    Route::post('/kyc/storenew', 'storenew');
    Route::get('/kyc/edit/{id}', 'edit');
    Route::post('/kyc/update', 'update');
    Route::get('/kyc/delete/{id}', 'destroy');
});


Route::controller(GiftController::class)->middleware(['auth'])->group(function () {
    Route::get('/gifts', 'index');
    Route::get('/gift/create', 'create');
    Route::post('/gift/store', 'store');
    Route::get('/gift/edit/{id}', 'edit');
    Route::post('/gift/update', 'update');
    Route::get('/gift/delete/{id}', 'destroy');
});


Route::controller(RedeemController::class)->middleware(['auth'])->group(function () {
    Route::get('/redeem-requests', 'index');
    Route::get('/getRedeemRequestsData', 'getRedeemRequestsData');
    Route::post('/request/update_status', 'update_request_status');
});



