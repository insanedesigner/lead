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

Route::post('/handleAgencyStatusChange', 'Admin\AgencyController@handleAgencyStatusChange')->name('agencyStatusChange');
Route::post('/loadStateOnCountries', 'Common\CommonController@loadStateOnCountries')->name('loadStateOnCountries');
Route::post('/loadCityOnStates', 'Common\CommonController@loadCityOnStates')->name('loadCityOnStates');
Route::post('/loadLead', 'Admin\LeadController@loadLead')->name('autocomplete');
Route::post('/mapLeadToAgency', 'Admin\LeadController@mapLeadToAgency');
Route::post('/loadMapLeadAgency', 'Admin\LeadController@loadMapLeadAgency');
Route::post('/loadUser', 'Admin\UserController@loadLead')->name('autocomplete');
Route::post('/handleUserStatusChange', 'Admin\UserController@handleUserStatusChange')->name('handleUserStatusChange');
Route::post('/handleEmailCheck', 'Admin\AgencyController@handleEmailCheck')->name('handleEmailCheck');
Route::post('/mapUserAgency', 'Admin\AgencyController@mapUserAgency')->name('mapUserAgency');
Route::post('/handleAddUserFromAgency', 'Admin\UserController@handleAddUserFromAgency')->name('handleAddUserFromAgency');



//Route::post('/testAjax', 'Admin\AdminController@streamDescriptionImageUploader')->name('streamImageUploader');
