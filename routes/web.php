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

Route::get('/', function () {
    return view('welcome');
});

Route::get('mail', 'MailController@requestRegisterMail');
Route::get('auth/facebook', 'FacebookController@redirectToProvider')->name('facebook.login')->prefix("customer");
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


Route::group(['prefix' => 'owner'], function(){
    Auth::routes();
});

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

Route::get("customer/category/{category}/products", "CustomerController@products");

Route::get("customer/category/{category}/products/{product}", "CustomerController@productDetails");

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