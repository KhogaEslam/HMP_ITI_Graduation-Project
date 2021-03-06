<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('api')->get("search", "CustomerController@searchPrefix");
//Route::middleware('api')->get("advanced-search", "SearchController@filter");


Route::middleware('api')->post("payment/confirm","CustomerController@verifyPayPalPayment");
Route::middleware('api')->post('customer/{product}/rating/add','CustomerController@submitRating');
Route::middleware('api')->get("customer/{product}/wishlist/add", "CustomerController@addToWishList");
Route::middleware('api')->post("customer/{product}/add_to_cart", "CustomerController@addToCart");
Route::middleware('api')->post("customer/{cart_detail}/edit_cart", "CustomerController@editCart");
Route::middleware('api')->post("cart/{product}/add_to_cart", "CustomerController@addToGuestCart");


