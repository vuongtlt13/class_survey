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
        Route::get('/examine', 'StudentController@survey')->name('student-survey');

        Route::get('/result', 'SurveyController@result')->name('survey-result');
    });

    Route::middleware(['lecturerRole'])->group(function () {

    });

    Route::middleware(['adminRole'])->group(function () {
        # User manager
        Route::get('/search-user', 'AdminController@searchUser')->name('search-user');

        Route::post('/create-user', 'AdminController@createUser')->name('create-user');

        Route::post('/update-user', 'AdminController@updateUser')->name('update-user');

        Route::post('/delete-user', 'AdminController@deleteUser')->name('delete-user');

        Route::post('/lock-user', 'AdminController@lockUser')->name('lock-user');

        Route::post('/unlock-user', 'AdminController@unlockUser')->name('unlock-user');

        Route::post('/reset-password', 'AdminController@resetPassword')->name('reset-password');

        Route::get('/user', 'AdminController@userManager')->name('admin-user');

        Route::post('/import-student', 'AdminController@importStudent')->name('import-student');

        Route::post('/import-lecturer', 'AdminController@importLecturer')->name('import-lecturer');
        #
        Route::get('/surveytemplate', 'AdminController@surveyTemplateManager')->name('admin-survey-template');

        Route::get('/survey', 'AdminController@surveyManager')->name('admin-survey');

        Route::get('/question', 'AdminController@questionManager')->name('admin-question');
    });

});
