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

Route::get('login', 'Auth\LoginController@showLogin')->name('login');
Route::any('handleLogin', 'Auth\LoginController@handleLogin')->name('handleLogin');;
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');



//Admin Controller
Route::any('admin/dashboard', 'Admin\AdminController@showDashboard')->name('adminDashboard')->middleware('validuser');
Route::any('admin/streams', 'Admin\AdminController@showAddStreams')->name('showAddStreams')->middleware('validuser');
Route::any('admin/handleAddStreamContents', 'Admin\AdminController@handleAddStreamContents')->name('handleAddStreamContents')->middleware('validuser');
Route::any('admin/handleAddStreamSeo', 'Admin\AdminController@handleAddStreamSeo')->name('handleAddStreamSeo')->middleware('validuser');
Route::any('admin/viewstreams', 'Admin\AdminController@showViewStreams')->name('showViewStreams')->middleware('validuser');




