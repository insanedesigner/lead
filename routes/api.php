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

Route::post('/streamDescriptionImageUpload', 'Admin\StreamsController@streamDescriptionImageUpload')->name('streamDescriptionImageUpload');
Route::post('/handleStreamStatusChange', 'Admin\StreamsController@handleStreamStatusChange')->name('handleStreamStatusChange');
Route::post('/coursesCategoryDescriptionImageUpload', 'Admin\CoursesCategoryController@coursesCategoryDescriptionImageUpload')->name('coursesCategoryDescriptionImageUpload');
Route::post('/loadCoursesCategory', 'Admin\AdminController@loadCoursesCategory')->name('loadCoursesCategory');
Route::post('/handleCoursesCategoryStatusChange', 'Admin\CoursesCategoryController@handleCoursesCategoryStatusChange')->name('handleCoursesCategoryStatusChange');
Route::post('/coursesDescriptionImageUpload', 'Admin\CoursesController@coursesDescriptionImageUpload')->name('coursesDescriptionImageUpload');
Route::post('/handleCoursesStatusChange', 'Admin\CoursesController@handleCoursesStatusChange')->name('handleCoursesStatusChange');
Route::post('/loadCoursesDetails', 'Common\CommonController@loadCoursesDetails')->name('loadCoursesDetails');
Route::post('/universityDescriptionImageUpload', 'Admin\UniversityController@universityDescriptionImageUpload')->name('universityDescriptionImageUpload');
Route::post('/loadStateOnCountries', 'Common\CommonController@loadStateOnCountries')->name('loadStateOnCountries');
Route::post('/loadCityOnStates', 'Common\CommonController@loadCityOnStates')->name('loadCityOnStates');
Route::post('/handleUniversityStatusChange', 'Admin\UniversityController@handleUniversityStatusChange')->name('handleUniversityStatusChange');
Route::post('/loadMediaForUniversity', 'Admin\UniversityController@loadMediaForUniversity')->name('loadMediaForUniversity');
Route::post('/handleUniversityMediaDelete', 'Admin\UniversityController@handleUniversityMediaDelete')->name('handleUniversityMediaDelete');


//Route::post('/testAjax', 'Admin\AdminController@streamDescriptionImageUploader')->name('streamImageUploader');
