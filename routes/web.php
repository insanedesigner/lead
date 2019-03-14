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

Route::any('admin/add_agency', 'Admin\AgencyController@showAddAgency')->name('addAgency')->middleware('validuser');
Route::any('admin/manage_agency', 'Admin\AgencyController@showManageAgency')->name('manageAgency')->middleware('validuser');
Route::any('admin/handleAddAgency', 'Admin\AgencyController@handleAddAgency')->name('handleAddAgency')->middleware('validuser');

Route::any('admin/add_leadtype', 'Admin\LeadController@showAddLeadType')->name('addLeadType')->middleware('validuser');
Route::any('admin/handleAddLeadType', 'Admin\LeadController@handleAddLeadType')->name('handleAddLeadType')->middleware('validuser');
Route::any('admin/manage_leadtype', 'Admin\LeadController@showManageLeadType')->name('manageLeadType')->middleware('validuser');
Route::any('admin/add_lead', 'Admin\LeadController@showAddLead')->name('addLead')->middleware('validuser');
Route::any('admin/handleAddLead', 'Admin\LeadController@handleAddLead')->name('handleAddLead')->middleware('validuser');
Route::any('admin/manage_lead', 'Admin\LeadController@showManageLead')->name('manageLead')->middleware('validuser');
Route::get('loadLead', 'Admin\LeadController@loadLead')->name('autocomplete');

Route::any('admin/add_user', 'Admin\UserController@showAddUser')->name('addUser')->middleware('validuser');
Route::any('admin/handleAddUser', 'Admin\UserController@handleAddUser')->name('handleAddUser')->middleware('validuser');
Route::any('admin/manage_user', 'Admin\UserController@showManageUser')->name('manageUser')->middleware('validuser');

Route::any('user/agency', 'Admin\UserController@showAgencySelectionPage')->name('showAgencySelectionPage')->middleware('validuser');


