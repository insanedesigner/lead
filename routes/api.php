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

Route::post('/streamDescriptionImageUpload', 'Admin\AdminController@streamDescriptionImageUpload')->name('streamDescriptionImageUpload');
Route::post('/streamFeatureThumbImageUpload', 'Admin\AdminController@streamFeatureThumbImageUpload')->name('streamFeatureThumbImageUpload');
Route::post('/handleStreamStatusChange', 'Admin\AdminController@handleStreamStatusChange')->name('handleStreamStatusChange');


//Route::post('/testAjax', 'Admin\AdminController@streamDescriptionImageUploader')->name('streamImageUploader');
