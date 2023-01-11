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
//Login
Route::any('/login','UserController@login')->name('login');

Route::group(['middleware' => ['auth', 'checkPermission']], function () {
    /*Home*/
    Route::get('/home','HomeController@index');
    /*Ajax*/
    Route::post('/ajax/changePassword','AjaxController@changePassword');
    Route::post('/ajax/loadTag','AjaxController@loadTag');
    /*Category*/
    Route::get('/category','CategoryController@index');
    Route::any('/category/update','CategoryController@update');
    Route::any('/category/update/{id}','CategoryController@update')->where(['id' => '[0-9]+']);
    Route::any('/category/delete/{id}','CategoryController@delete')->where(['id' => '[0-9]+']);
    /*Tour*/
    Route::get('/tour','TourController@index');
    Route::any('/tour/add','TourController@add');
    Route::any('/tour/edit/{id}','TourController@edit')->where(['id' => '[0-9]+']);
    Route::any('/tour/delete/{id}','TourController@delete')->where(['id' => '[0-9]+']);

    /*User*/
    Route::any('/user','UserController@index');
    Route::any('/user/update','UserController@update');
    Route::any('/user/update/{id}','UserController@update')->where(['id' => '[0-9]+']);
    Route::any('/user/delete/{id}','UserController@delete')->where(['id' => '[0-9]+']);
    Route::any('/user/logout','UserController@logout');

    /*Post*/
    Route::get('/post','PostController@index');
    Route::any('/post/update','PostController@update');
    Route::any('/post/update/{id}','PostController@update')->where(['id' => '[0-9]+']);
    Route::any('/post/delete/{id}','PostController@delete')->where(['id' => '[0-9]+']);

    /*Group Permission*/
    Route::get('/group','GroupController@index');
    Route::any('/group/update','GroupController@update');
    Route::any('/group/update/{id}','GroupController@update')->where(['id' => '[0-9]+']);
    Route::any('/group/delete/{id}','GroupController@delete')->where(['id' => '[0-9]+']);

    /*Site setting*/
    Route::any('/site_setting/update','Site_SettingController@update');
    Route::any('/site_setting/daga','Site_SettingController@updateSettingDaGa');
    /*Redirect*/
    Route::get('/redirect','RedirectController@index');
    Route::any('/redirect/update','RedirectController@update');
    Route::any('/redirect/update/{id}','RedirectController@update')->where(['id' => '[0-9]+']);
    Route::any('/redirect/delete/{id}','RedirectController@delete')->where(['id' => '[0-9]+']);

});
