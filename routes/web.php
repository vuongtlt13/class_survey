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

Route::get('/login', 'LoginController@login')->name('login');

Route::get('/profile', 'UserController@profile')->name('login');

Route::get('/admin/user-manager', 'AdminController@userManager')->name('admin-user-manager');

Route::get('/admin/survey-questionnaire-manager', 'AdminController@surveyQuestionnaireManager')->name('admin-survey-questionnaire-manager');

Route::get('/admin', 'AdminController@index')->name('admin-index');

Route::get('/student', function () {
    return view('student');
});

Route::get('/teacher', function () {
    return view('teacher');
});

Route::get('/survey', function () {
    return view('survey');
});

Route::get('/result', function () {
    return view('view_result');
});
