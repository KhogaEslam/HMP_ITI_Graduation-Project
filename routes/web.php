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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

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

Route::get('/admin/categories', 'AdminController@listCategories');
Route::get('/admin/categories/new', 'AdminController@newCategory');
Route::post('/admin/categories/create', 'AdminController@createCategory');
Route::get('/admin/categories/{category_id}/edit', 'AdminController@editCategory');
Route::post('/admin/categories/{category_id}/update', 'AdminController@updateCategory');
Route::post('/admin/categories/{category_id}/delete', 'AdminController@deleteCategory');




