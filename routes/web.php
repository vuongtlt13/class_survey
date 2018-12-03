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

Route::get('/example', function () {
    return view('example');
});

Route::get('/', 'LoginController@index')->name('index');

Route::get('/login', 'LoginController@login')->name('login');

Route::get('/profile', 'UserController@profile')->name('login');

Route::get('/admin/user', 'AdminController@userManager')->name('admin-user');

Route::get('/admin/surveytemplate', 'AdminController@surveyTemplateManager')->name('admin-survey-template');

Route::get('/admin/survey', 'AdminController@surveyManager')->name('admin-survey');

Route::get('/admin/question', 'AdminController@questionManager')->name('admin-question');

Route::get('/admin', 'AdminController@index')->name('admin-index');

Route::get('/student', 'StudentController@index')->name('student-index');

Route::get('/teacher', 'TeacherController@index')->name('teacher-index');

Route::get('/survey', 'StudentController@survey')->name('student-survey');

Route::get('/result', 'SurveyController@result')->name('survey-result');
