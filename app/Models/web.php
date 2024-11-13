<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;

// MY Controller

use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CollateralController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacilitieController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\Offer_CategorieController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\OfferGroupController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\SitePolicyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\influencerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\SupportVideoController;
use App\Http\Controllers\RedeemController;



use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', ['middleware' => ['auth'], function () {

    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        return redirect()->guest('login');
    }
}]);

Auth::routes();

Route::get('/view-clear', function () {
    Artisan::call('optimize:clear');
    return 'Optimize Clear all cache';
});


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});


Route::controller(HomeController::class)->group(function () {
    Route::get('/dashboard', 'index');
});

Route::controller(DepartmentController::class)->middleware(['auth'])->group(function () {
    Route::get('/depar3. gfsZDXC VNtments', 'index');
    Route::get('/getDepartmentsData', 'getDepartmentsData');
    Route::get('/department/create', 'create');
    Route::post('/department/store', 'store');
    Route::get('/department/edit/{id}', 'edit');
    Route::post('/department/update', 'update');
    Route::get('/department/delete/{id}', 'destroy');
});

Route::controller(LegalController::class)->middleware(['auth'])->group(function () {
    Route::get('/legals', 'index');
    Route::get('/getLegalsData', 'getLegalsData');
    Route::get('/legal/create', 'create');
    Route::post('/legal/store', 'store');
    Route::get('/legal/edit/{id}', 'edit');
    Route::post('/legal/update', 'update');
    Route::get('/city/getcity/{id}', 'getcity');

    Route::get('/legal/delete/{id}', 'destroy');
});
Route::controller(CityController::class)->middleware(['auth'])->group(function () {
    Route::get('/cities', 'index');
    Route::get('/getCitiesData', 'getCitiesData');
    Route::get('/city/create', 'create');
    Route::post('/city/store', 'store');
    Route::get('/city/edit/{id}', 'edit');
    Route::post('/city/update', 'update');
    Route::get('/city/getstate/{id}', 'getstate');
    Route::get('/city/getcity/{id}', 'getcity');
    Route::get('/city/delete/{id}', 'destroy');
});

Route::controller(BrandController::class)->middleware(['auth'])->group(function () {
    Route::get('/brands', 'index');
    Route::get('/getBrandsData', 'getBrandsData');
    Route::get('/brand/create', 'create');
    Route::post('/brand/storebrand', 'storebrand');
    Route::get('/brand/edit/{id}', 'edit');
    Route::post('/brand/update', 'update');
    Route::get('/brand/delete/{id}', 'destroy');
});

Route::controller(OutletController::class)->middleware(['auth'])->group(function () {
    Route::get('/outlets', 'index');
    Route::get('/getOutletsData', 'getOutletsData');
    Route::get('/outlet/create', 'create');
    Route::post('/outlet/storeoutlet', 'storeoutlet');
    Route::get('/outlet/edit/{id}', 'edit');
    Route::post('/outlet/update', 'update');
    Route::get('/outlet/delete/{id}', 'destroy');
});

Route::controller(CollateralController::class)->middleware(['auth'])->group(function () {
    Route::get('/collaterals', 'index');
    Route::get('/getCollateralsData', 'getCollaterlsData');
    Route::get('/collateral/create', 'create');
    Route::post('/collateral/store', 'store');
    Route::get('/collateral/edit/{id}', 'edit');
    Route::post('/collateral/update', 'update');
    Route::get('/collateral/delete/{id}', 'destroy');
});

Route::controller(Offer_CategorieController::class)->middleware(['auth'])->group(function () {
    Route::get('/offer_categorie', 'index');
    Route::get('/Offer_CategoriesData', 'getOffer_CategoriesData');
    Route::get('/offer_categorie/create', 'create');
    Route::post('/offer_categorie/store', 'store');
    Route::get('/offer_categorie/edit/{id}', 'edit');
    Route::post('/offer_categorie/update', 'update');
    Route::get('/offer_categorie/delete/{id}', 'destroy');
});
Route::controller(FacilitieController::class)->middleware(['auth'])->group(function () {
    Route::get('/facilitie', 'index');
    Route::get('/FacilitiesData', 'getFacilitiesData');
    Route::get('/facilitie/create', 'create');
    Route::post('/facilitie/store', 'store');
    Route::get('/facilitie/edit/{id}', 'edit');
    Route::post('/facilitie/update', 'update');
    Route::get('/facilitie/delete/{id}', 'destroy');
});

Route::controller(CategoryController::class)->middleware(['auth'])->group(function () {
    Route::get('/product_categories', 'index');
    Route::get('/getCategoriesData', 'getCategoriesData');
    Route::post('/product_category/store', 'store');
    Route::get('/product_category/edit/{id}', 'edit');
    Route::post('/product_category/update', 'store');
    Route::get('/product_category/delete/{id}', 'destroy');
    Route::get('/getCategories', 'getCategories');
    Route::get('/getSubCategories', 'getSubCategories');
});


Route::controller(SupportVideoController::class)->middleware(['auth'])->group(function () {
    Route::get('/support-videos', 'index');
    Route::get('/getVideosData', 'getVideosData');
    Route::post('/support_video/store', 'store');
    Route::get('/support_video/edit/{id}', 'edit');
    Route::post('/support_video/update', 'store');
    Route::get('/support_video/delete/{id}', 'destroy');
});


Route::controller(ProductController::class)->middleware(['auth'])->group(function () {
    Route::get('/products', 'index')->name('product.list');
    Route::get('/getProductsData', 'getProductsData');
    Route::get('/product/create', 'create');
    Route::post('/product/store', 'store')->name('product.store');
    Route::get('/product/edit/{id}', 'edit');
    Route::post('/product/update', 'update');
    Route::get('/product/delete/{id}', 'destroy');
    Route::get('/product/images/{id}', 'images');
    Route::post('/product/image/store/{id}', 'store_images');
    Route::post('/product/image/delete/', 'delete_images');
    Route::get('/product/variants/{id}', 'variants');
    Route::post('/product/store_variant_details', 'store_variant_details');
    Route::post('/product/set_variant_cost', 'set_variant_cost');
    Route::get('/product/seo_data/{id}', 'seo_data');
    Route::post('/product/store_seo_details', 'update_seo_data');
    Route::get('/product/product_images/{id}', 'product_images');
    Route::get('/product/set_thumb_image/{id}', 'set_thumb_image');
    Route::get('/product/set_variant_image/{id}/{sku}', 'set_variant_image');
    Route::get('/product/options/{id}', 'set_product_options');
    Route::post('/product/store_options_details', 'store_options_details');
    Route::get('/product/change_option_status/{id}', 'change_option_status');
    Route::get('/product/set_default_variant/{id}', 'set_default_variant');
    Route::get('/product/deactivate_variant/{id}', 'deactivate_variant');
});

Route::controller(TaxController::class)->middleware(['auth'])->group(function () {
    Route::get('/taxes', 'index')->name('tax.list');
    Route::get('/getTaxesData', 'getTaxesData');
    Route::post('/tax/store', 'store');
    Route::get('/tax/edit/{id}', 'edit');
    Route::get('/tax/delete/{id}', 'destroy');
    Route::get('/getTaxes', 'getTaxes');
});

Route::controller(ClientController::class)->middleware(['auth'])->group(function () {
    Route::get('/clients', 'index');
    Route::get('/getClientsData', 'getClientsData');
    Route::get('/client/create', 'create');
    Route::post('/client/store', 'store');
    Route::get('/client/edit/{id}', 'edit');
    Route::post('/client/update', 'update');
    Route::get('/client/delete/{id}', 'destroy');
});

Route::controller(ProgramController::class)->middleware(['auth'])->group(function () {
    Route::get('/programs', 'index');
    Route::get('/getProgramsData', 'getProgramsData');
    Route::get('/program/create', 'create');
    Route::post('/program/program_store', 'program_store');
    Route::get('/program/edit/{id}', 'edit');
    Route::post('/program/update', 'update');
    Route::get('/program/delete/{id}', 'destroy');
    Route::get('/program_bins/{id}', 'program_bins');
    Route::get('/getProgramBinsData', 'getProgramBinsData');
});

Route::controller(AttributeController::class)->middleware(['auth'])->group(function () {
    Route::get('/attributes', 'index');
    Route::get('/getAttributesData', 'getAttributesData');
    Route::get('/attribute/create', 'create');
    Route::post('/attribute/store', 'store');
    Route::get('/attribute/edit/{id}', 'edit');
    Route::get('/attribute/delete/{id}', 'destroy');
    Route::get('/getAttributes', 'getAttributes');
});


Route::controller(PartnerController::class)->middleware(['auth'])->group(function () {
    Route::get('/partners', 'index');
    Route::get('/getPartnersData', 'getPartnersData');
    Route::get('/partner/create', 'create');
    Route::post('/partner/store', 'store');
    Route::get('/partner/edit/{id}', 'edit');
    Route::post('/partner/update', 'update');
    Route::get('/partner/delete/{id}', 'destroy');

    Route::get('/partner/manage_offers/{id}', 'offers');
    Route::get('/getPartnerOffersData/{id}', 'getPartnerOffersData');
    Route::get('/partner/create_offer/{id}', 'create_offer');
    Route::get('/partner/edit_offer/{oid}', 'edit_offer');
    Route::post('/partner/store_offer', 'store_offer');
});


Route::controller(OfferGroupController::class)->middleware(['auth'])->group(function () {
    Route::get('/offer_groups', 'index');
    Route::get('/getOfferGroupsData', 'getOfferGroupsData');
    Route::get('/offer_group/create', 'create');
    Route::post('/offer_group/store', 'store');
    Route::get('/offer_group/edit/{id}', 'edit');
    Route::post('/offer_group/update', 'update');
    Route::get('/offer_group/delete/{id}', 'destroy');
});


Route::controller(SitePolicyController::class)->middleware(['auth'])->group(function () {
    Route::get('/policies', 'index');
    Route::get('/getSitePoliciesData', 'getSitePoliciesData');
    Route::get('/policy/create', 'create');
    Route::post('/policy/store', 'store');
    Route::get('/policy/edit/{id}', 'edit');
    Route::post('/policy/update', 'update');
    Route::get('/policy/delete/{id}', 'destroy');
});



Route::controller(OrderController::class)->middleware(['auth'])->group(function () {
    Route::get('/orders', 'index');
    Route::get('/getOrdersData', 'getOrdersData');
    Route::get('/order_details/{id}', 'order_details');
});


Route::controller(PromotionController::class)->middleware(['auth'])->group(function () {
    Route::get('/promotions', 'index');
    Route::get('/getPromotionsData', 'getPromotionsData');
    Route::get('/promotion/create', 'create');
    Route::post('/promotion/store', 'store');
    Route::get('/promotion/details/{id}', 'promotion_details');
});




Route::controller(GeneralController::class)->middleware(['auth'])->group(function () {
    Route::get('/generals', 'index');
    Route::get('/getGeneralsData', 'getGeneralsData');
    Route::get('/general/create', 'create');
    Route::post('/general/store', 'store');
    Route::get('/general/edit/{id}', 'edit');
    Route::post('/general/update', 'update');
    Route::get('/general/delete/{id}', 'destroy');
});


Route::controller(QueryController::class)->middleware(['auth'])->group(function () {
    Route::get('/queries', 'index');
    Route::get('/user-queries', 'userQueries');
    Route::get('/getQueriesData', 'getQueriesData');
    Route::get('/getUserQueriesData', 'getUserQueriesData');
    Route::get('/query/close/{id}', 'close_query');
});


Route::controller(BannerController::class)->middleware(['auth'])->group(function () {
    Route::get('/banners', 'index');
    Route::get('/banner/images/{id}', 'banner_images');
    Route::post('/banner/image/store/{id}', 'store_images');
    Route::post('/banner/image/delete/', 'delete_image');
    
});




// New Routes Imported

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
    Route::get('/getGiftsData/{id}', 'getGiftsData');
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