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



Route::any('admin/streams', 'Admin\StreamsController@showAddStreams')->name('showAddStreams')->middleware('validuser');
Route::any('admin/handleAddStreamContents', 'Admin\StreamsController@handleAddStreamContents')->name('handleAddStreamContents')->middleware('validuser');
Route::any('admin/manage_streams', 'Admin\StreamsController@showViewStreams')->name('showViewStreams')->middleware('validuser');

Route::any('admin/coursescategory', 'Admin\CoursesCategoryController@showCoursesCategory')->name('showCoursesCategory')->middleware('validuser');
Route::any('admin/handleAddCoursesCategory', 'Admin\CoursesCategoryController@handleAddCoursesCategory')->name('handleAddCoursesCategory')->middleware('validuser');
Route::any('admin/manage_courses_category', 'Admin\CoursesCategoryController@showViewCoursesCategory')->name('showViewCoursesCategory')->middleware('validuser');

Route::any('admin/courses', 'Admin\CoursesController@showCourses')->name('showCourses')->middleware('validuser');
Route::any('admin/handleAddCourses', 'Admin\CoursesController@handleAddCourses')->name('handleAddCourses')->middleware('validuser');
Route::any('admin/manage_courses', 'Admin\CoursesController@showViewCourses')->name('showViewCourses')->middleware('validuser');

Route::any('admin/university', 'Admin\UniversityController@showAddUniversity')->name('showAddUniversity')->middleware('validuser');
Route::any('admin/handleAddUniversity', 'Admin\UniversityController@handleAddUniversity')->name('handleAddUniversity')->middleware('validuser');
Route::any('admin/manage_university', 'Admin\UniversityController@showManageUniversity')->name('showManageUniversity')->middleware('validuser');
Route::any('admin/media_university', 'Admin\UniversityController@showMedia')->name('showMedia')->middleware('validuser');
Route::any('admin/handleLogoUploads', 'Admin\UniversityController@handleLogoUploads')->name('handleLogoUploads')->middleware('validuser');
Route::any('admin/handleUniversityImagesUploads', 'Admin\UniversityController@handleUniversityImagesUploads')->name('handleUniversityImagesUploads')->middleware('validuser');
Route::any('admin/handleUniversityBroucherUploads', 'Admin\UniversityController@handleUniversityBroucherUploads')->name('handleUniversityBroucherUploads')->middleware('validuser');
Route::any('admin/courses_university', 'Admin\UniversityController@showUniversityCourseMapping')->name('showUniversityCourseMapping')->middleware('validuser');
Route::any('admin/handleUniversityCoursesMapping', 'Admin\UniversityController@handleUniversityCoursesMapping')->name('handleUniversityCoursesMapping')->middleware('validuser');


Route::any('admin/colleges', 'Admin\CollegeController@showCollege')->name('showCollege')->middleware('validuser');




