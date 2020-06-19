<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*everytime need not to type admin in url so prefix and everytime no need to specify
Admin folder(controllers) so namespace*/
// Route::group(['prefix' => '/admin','namespace' => 'Admin'],function(){
// //all admincontroller functions

//     Route::group(['middleware'=>['admin']],function(){
//         Route::get('/dashboard','AdminController@dashboard');       
//     });
    
//     Route::match(['get','post'],'/','AdminController@login');


// });


Route::group(['prefix' => '/admin','namespace' => 'Admin'],function(){

    //all admincontroller functions

    Route::match(['get','post'],'/','AdminController@login');
    Route::group(['middleware'=>['admin']],function(){
        Route::get('dashboard','AdminController@dashboard'); 
        Route::get('settings','AdminController@settings'); 
        //check-current-pwd is also present in admin_scripts.js    
        Route::post('check-current-pwd','AdminController@chkCurrentPassword'); 
        Route::post('update-current-pwd','AdminController@updateCurrentPassword'); 
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');
        Route::get('logout','AdminController@logout');  
        
        //Sections
        Route::get('sections','SectionController@section');
        Route::match(['get','post'],'add-section','SectionController@addSection');
        Route::post('update-section-status','SectionController@updateSectionStatus');

        //categories
        Route::get('categories','CategoryController@categories');
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');
        Route::post('append-categories-level','CategoryController@appendCategoryLevel');
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');
        Route::get('delete-category/{id}','CategoryController@deleteCategory');

        //customers
        Route::get('customers','CustomerController@customers');
        Route::match(['get','post'],'add-customer','CustomerController@addCustomer');
        Route::get('delete-customer/{id}','CustomerController@deleteCustomer');
    });
          
    
    });