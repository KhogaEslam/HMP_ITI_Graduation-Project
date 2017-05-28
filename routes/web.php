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

//Route::get('/', function () {
//    return view('customer.index');
//});
Route::get('/', 'CustomerController@index');


Route::get('mail', 'MailController@requestRegisterMail');
Route::get('auth/facebook', 'FacebookController@redirectToProvider')
    ->name('facebook.login')
    ->prefix("customer");
Route::get('auth/facebook/callback', 'FacebookController@handleProviderCallback');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'owner'], function(){
    Auth::routes();
});

Route::group(['prefix' => 'admin'], function(){
    Auth::routes();
});

Route::group(['prefix' => 'vendor'], function(){
    Auth::routes();
});

Route::group(['prefix' => 'customer'], function(){
    Auth::routes();
});

//================================= Admin dashboard Routes =====================================//

//Entrust::routeNeedsRole("admin/*", "admin");
//===================   Home     ======================//
Route::get('/admin', 'AdminController@index');

//=================== Categories ======================//
Route::get('/admin/categories', 'AdminController@listCategories');
Route::get('/admin/categories/new', 'AdminController@newCategory');
Route::post('/admin/categories/create', 'AdminController@createCategory');
Route::get('/admin/categories/{category}/edit', 'AdminController@editCategory');
Route::post('/admin/categories/{category}/update', 'AdminController@updateCategory');
Route::post('/admin/categories/{category}/delete', 'AdminController@deleteCategory');

//===============================    End Route  =================================================//


//Entrust::routeNeedsRole("vendor/*", "vendor", Redirect::to("vendor/login"));

Route::get("vendor", "VendorController@index");

Route::get("vendor/category/{category}/products", "VendorController@category");

Route::get("vendor/category/{category}/new_product", "VendorController@showNewProductForm");

Route::post("vendor/category/{category}/new_product", "VendorController@newProduct");

Route::get("vendor/category/{category}/product/{product}", "VendorController@productDetails");

Route::get("vendor/category/{category}/product/{product}/edit", "VendorController@showEditProductForm");

Route::post("vendor/category/{category}/product/{product}/edit", "VendorController@editProduct");

Route::post("vendor/category/{category}/product/{product}/delete", "VendorController@deleteProduct");

Route::post("vendor/category/{category}/product/{product}/publish", "VendorController@publishProduct");

Route::post("vendor/category/{category}/product/{product}/unpublish", "VendorController@unPublishProduct");

Route::get("customer", "CustomerController@index");

Route::get("category/{category}/products", "CustomerController@products");

Route::get("category/{category}/products/{product}", "CustomerController@productDetails");

Route::group(["prefix" => "vendor/employees", "middleware" => "vendor.auth"], function() {

    Route::get("/", "VendorController@showEmployees");

    Route::get("new_employee", "VendorController@showNewEmployeeForm");

    Route::post("new_employee", "VendorController@newEmployee");

    Route::get("{employee}/edit_employee", "VendorController@showEditEmployeeForm");

    Route::post("{employee}/edit_employee", "VendorController@editEmployee");

    Route::post("{employee}/delete_employee", "VendorController@deleteEmployee");
});

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

Route::get("admin/new_offer", "AdminController@showAddOfferForm");

Route::post("admin/new_offer", "AdminController@addOffer");

Route::post("customer/{product}/add_to_cart", "CustomerController@addToCart");

Route::post("customer/{cart_detail}/edit_cart", "CustomerController@editCart");

//add discount
Route::get("vendor/product/{product}/discount", "VendorController@showDiscountProductForm");

Route::get("customer/cart", "CustomerController@viewCart");
Route::post("vendor/product/{product}/add_discount", "VendorController@newDiscount");

//edit discount
Route::get("vendor/product/{product}/discount/edit", "VendorController@showEditDiscountProductForm");

Route::post("vendor/product/{product}/edit_discount", "VendorController@editDiscount");

Route::post("customer/cart/{cart_detail}/delete", "CustomerController@deleteProductFromCart");