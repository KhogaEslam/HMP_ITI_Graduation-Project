<?php
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
//============================= Main Home Routes ====================================//
Route::get('/', 'CustomerController@index');
Route::get('/home', 'HomeController@index')->name('home');
//=============================   End main home routes ===============================//
//====================== Registration and login with social media ====================//
Route::get('mail', 'MailController@requestRegisterMail');
Route::get('auth/facebook', 'FacebookController@redirectToProvider')
    ->name('facebook.login')
    ->prefix("customer");
Route::get('auth/facebook/callback', 'FacebookController@handleProviderCallback');
Route::group(['prefix' => 'owner'], function(){
    Auth::routes();
});
Route::group(['prefix' => 'admin'], function(){
    Auth::routes();
});
Route::group(['prefix' => 'shop'], function(){
    Auth::routes();
});
Route::group(['prefix' => 'customer'], function(){
    Auth::routes();
});
//=====================End Registration and login with social media ===================//
//================================= Admin Routes =====================================//
//===================   Home     ======================//
Route::get('/admin', 'AdminController@index');
//=================== Categories ======================//
Route::get('/admin/categories', 'AdminController@listCategories');
Route::get('/admin/categories/new', 'AdminController@newCategory');
Route::post('/admin/categories/create', 'AdminController@createCategory');
Route::get('/admin/categories/{category}/edit', 'AdminController@editCategory');
Route::post('/admin/categories/{category}/update', 'AdminController@updateCategory');
Route::post('/admin/categories/{category}/delete', 'AdminController@deleteCategory');
//============== Registration Requests  ================//
Route::get('/admin/registration-requests' , 'AdminController@viewAllRegRequests');
Route::post('/admin/registration-requests/{regReq}/accept', 'AdminController@acceptRegRequest');
Route::post('/admin/reregistration-requests/{regReq}/reject', 'AdminController@rejectRegRequest');
//=============== Category creation requests ===============//
Route::get('/admin/category-requests', 'AdminController@viewAllCatCreationRequests');
Route::post('/admin/category-requests/{catReq}/accept' , 'AdminController@acceptCatCreationRequest');
Route::post('/admin/category-requests/{catReq}/reject',  'AdminController@rejectCatCreationRequest');
//=====================    Users  ==========================//
Route::get('/admin/users','AdminController@listUsers');
Route::post('/admin/users/{user}/block', 'AdminController@blockUser');
Route::post('/admin/users/{user}/suspend', 'AdminController@suspendUser');
Route::post('/admin/users/{user}/resume', 'AdminController@unsuspendUser');
Route::get('/admin/users/new-admin','AdminController@newAdminUser');
Route::post('/admin/users/create-admin', 'AdminController@createAdminUser');
//=====================   Banner Requests  =========================//
Route::get("admin/banner_requests", "AdminController@viewBannerRequests");
Route::post("admin/banner_request/{banner_request}/accept", "AdminController@acceptBannerRequest");
Route::post("admin/banner_request/{banner_request}/reject", "AdminController@rejectBannerRequest");
//=====================       Offers       =========================//
Route::get("admin/new_offer", "AdminController@showAddOfferForm");
Route::post("admin/new_offer", "AdminController@addOffer");
//=====================     Featured Requests =======================//
Route::get("admin/featured_requests", "AdminController@viewFeaturedRequests");
Route::post("admin/featured_request/{featured_request}/accept", "AdminController@acceptFeaturedRequest");
Route::post("admin/featured_request/{featured_request}/reject", "AdminController@rejectFeaturedRequest");
//===============================    End Admin Route  =================================================//
//================================== Shop Routes  ==================================================//
//=====================   Home =====================//
Route::get("shop", "VendorController@index");
//==================== Categories ==================//
Route::get('shop/category/new' , 'VendorController@newCategory');
Route::post('shop/category/request', 'VendorController@requestCategory');
//====================   Products =====================//
Route::get("shop/category/{category}/products", "VendorController@category");
Route::get("shop/category/{category}/new_product", "VendorController@showNewProductForm");
Route::post("shop/category/{category}/new_product", "VendorController@newProduct");
Route::get("shop/category/{category}/product/{product}", "VendorController@productDetails");
Route::get("shop/category/{category}/product/{product}/edit", "VendorController@showEditProductForm");
Route::post("shop/category/{category}/product/{product}/edit", "VendorController@editProduct");
Route::post("shop/category/{category}/product/{product}/delete", "VendorController@deleteProduct");
Route::post("shop/category/{category}/product/{product}/publish", "VendorController@publishProduct");
Route::post("shop/category/{category}/product/{product}/unpublish", "VendorController@unPublishProduct");
//===================== Discounts ====================//
Route::get("shop/product/{product}/discount", "VendorController@showDiscountProductForm");
Route::get("shop/product/{discount}/discount/delete", "VendorController@deleteDiscount");
Route::post("shop/product/{product}/add_discount", "VendorController@newDiscount");
//================  Featured Item Requests ===========//
Route::get("shop/product/{product}/featuredItem", "VendorController@makeFeaturedItemRequest");
//======================   Banners ===================//
Route::get("shop/add_banner", "VendorController@showBannerRequestForm");
Route::post("shop/add_banner", "VendorController@addBannerRequest");
//=====================   Employees ==================//
Route::group(["prefix" => "shop/employees", "middleware" => "vendor.auth"], function() {
    Route::get("/", "VendorController@showEmployees");
    Route::get("new_employee", "VendorController@showNewEmployeeForm");
    Route::post("new_employee", "VendorController@newEmployee");
    Route::get("{employee}/edit_employee", "VendorController@showEditEmployeeForm");
    Route::post("{employee}/edit_employee", "VendorController@editEmployee");
    Route::post("{employee}/delete_employee", "VendorController@deleteEmployee");
});
//================================= End Vendor Routes ========================================================//
//===================================== Customer Routes ======================================================//
//====================  Home  ======================//
Route::get("customer", "CustomerController@index");
Route::get("customer/shop/{vendor_id}", "CustomerController@index");
//==================== Products ====================//
Route::get("category/{category}/products", "CustomerController@products");
Route::get("category/{category}/products/{product}", "CustomerController@productDetails");
Route::get("category/popularCategories/show", "CustomerController@showPopularCategories");
//==================== Cart =========================//
Route::post("customer/{product}/add_to_cart", "CustomerController@addToCart");
Route::post("customer/{cart_detail}/edit_cart", "CustomerController@editCart");
Route::get("customer/cart", "CustomerController@viewCart");
Route::post("customer/cart/{cart_detail}/delete", "CustomerController@deleteProductFromCart");
//=================== WishList ======================//
Route::get("customer/wishlist/show", "CustomerController@showWishList");
Route::get("customer/{product}/wishlist/add", "CustomerController@addToWishList");
Route::get("customer/{item}/wishlist/delete", "CustomerController@deleteFromWishList");
//===================  Rating =======================//
Route::post('customer/{product}/rating/add','CustomerController@submitRating');
//==================== Search ======================//
Route::get("customer/search", "CustomerController@search");
//==================== About ======================//
Route::get("customer/about", "CustomerController@showAbout");
//=================================== End Customer Routes =======================================================//
//===================================    Files Routes  ===========================================================//
//================= product images ==================//
Route::get('images/{filename}', function($filename){
    $path = resource_path() . '/img/' . $filename;
    if(!File::exists($path)) {
        return response()->json(['message' => 'Image not found.'], 404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->name("image");
//================= Banner files ====================//
Route::get('banner/{filename}', function($filename){
    $path = resource_path() . '/banner/' . $filename;
    if(!File::exists($path)) {
        return response()->json(['message' => 'Image not found.'], 404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->name("banner");
//===================================  End files Routes ==============================================================//
//=====================================    Paypal ===================================================================//
Route::resource("payment","PaymentController");
//=====================================   End Paypal Routes ========================================================///
