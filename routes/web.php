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

Route::get('/login', 'LoginController@login')->name('login');
Route::post('/login', 'LoginController@authentication')->name('authentication');

Route::middleware(['userChecker'])->group(function () {
    Route::get('/profile', 'UserController@profile')->name('profile');

    Route::get('/logout', 'LoginController@logout')->name('logout');

    Route::get('/', 'LoginController@index')->name('index');

    Route::middleware(['studentRole'])->group(function () {
        // Route::get('/student', 'StudentController@index')->name('student-index');

        Route::get('/survey', 'StudentController@survey')->name('student-survey');

        Route::get('/result', 'SurveyController@result')->name('survey-result');
    });

    Route::middleware(['lecturerRole'])->group(function () {
        // Route::get('/teacher', 'TeacherController@index')->name('teacher-index');
    });

    Route::middleware(['adminRole'])->group(function () {
      Route::get('/user', 'AdminController@userManager')->name('admin-user');

      Route::get('/surveytemplate', 'AdminController@surveyTemplateManager')->name('admin-survey-template');

      Route::get('/survey', 'AdminController@surveyManager')->name('admin-survey');

      Route::get('/question', 'AdminController@questionManager')->name('admin-question');

      // Route::get('/admin', 'AdminController@index')->name('admin-index');
    });

});
