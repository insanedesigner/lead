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
Route::any('admin/streams', 'Admin\StreamsController@showAddStreams')->name('showAddStreams')->middleware('validuser');
Route::any('admin/handleAddStreamContents', 'Admin\StreamsController@handleAddStreamContents')->name('handleAddStreamContents')->middleware('validuser');
Route::any('admin/viewstreams', 'Admin\StreamsController@showViewStreams')->name('showViewStreams')->middleware('validuser');
Route::any('admin/coursescategory', 'Admin\CoursesCategoryController@showCoursesCategory')->name('showCoursesCategory')->middleware('validuser');
Route::any('admin/handleAddCoursesCategory', 'Admin\CoursesCategoryController@handleAddCoursesCategory')->name('handleAddCoursesCategory')->middleware('validuser');
Route::any('admin/viewcoursescategory', 'Admin\CoursesCategoryController@showViewCoursesCategory')->name('showViewCoursesCategory')->middleware('validuser');
Route::any('admin/courses', 'Admin\CoursesController@showCourses')->name('showCourses')->middleware('validuser');
Route::any('admin/handleAddCourses', 'Admin\CoursesController@handleAddCourses')->name('handleAddCourses')->middleware('validuser');
Route::any('admin/viewcourses', 'Admin\CoursesController@showViewCourses')->name('showViewCourses')->middleware('validuser');
Route::any('admin/university', 'Admin\UniversityController@showAddUniversity')->name('showAddUniversity')->middleware('validuser');
Route::any('admin/handleAddUniversity', 'Admin\UniversityController@handleAddUniversity')->name('handleAddUniversity')->middleware('validuser');



