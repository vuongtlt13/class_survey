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

    Route::post('/profile/update', 'UserController@updateProfile')->name('update-profile');

    Route::get('/logout', 'LoginController@logout')->name('logout');

    Route::get('/', 'LoginController@index')->name('index');

    Route::middleware(['studentRole'])->group(function () {
        Route::get('/examine/{class_id}', 'StudentController@survey')->name('student-survey');

        Route::post('/sendsurvey', 'StudentController@sendSurvey')->name('send-survey');

        Route::get('/result/{class_id}', 'StudentController@result')->name('view-survey');
    });

    Route::middleware(['lecturerRole'])->group(function () {
       Route::get('/view/{idClass}', 'TeacherController@detailResult')->name('detail-result');
       Route::get('/view/subject/{idSubject}', 'TeacherController@subjectResult')->name('subject-result');
    });

    Route::middleware(['adminRole'])->group(function () {
        # User manager
        Route::get('/search-user', 'AdminController@searchUser')->name('search-user');

        Route::post('/create-user', 'AdminController@createUser')->name('create-user');

        Route::post('/update-user', 'AdminController@updateUser')->name('update-user');

        Route::post('/delete-user', 'AdminController@deleteUser')->name('delete-user');

        Route::post('/delete--user', 'AdminController@deleteAllUser')->name('delete-all-user');

        Route::post('/lock-user', 'AdminController@lockUser')->name('lock-user');

        Route::post('/unlock-user', 'AdminController@unlockUser')->name('unlock-user');

        Route::post('/reset-password', 'AdminController@resetPassword')->name('reset-password');

        Route::get('/user', 'AdminController@userManager')->name('admin-user');

        Route::post('/import-student', 'AdminController@importStudent')->name('import-student');

        Route::post('/import-lecturer', 'AdminController@importLecturer')->name('import-lecturer');

        # Title-Question manager
        Route::get('/question', 'AdminController@questionManager')->name('admin-question');

        Route::post('/create-title', 'AdminController@createTitle')->name('create-title');

        Route::post('/create-question', 'AdminController@createQuestion')->name('create-question');

        Route::post('/update-title', 'AdminController@updateTitle')->name('update-title');

        Route::post('/update-question', 'AdminController@updateQuestion')->name('update-question');

        Route::post('/delete-title', 'AdminController@deleteTitle')->name('delete-title');

        Route::post('/delete-question', 'AdminController@deleteQuestion')->name('delete-question');

        Route::get('/get-title', 'QuestionController@getTitle')->name('get-title');

        Route::get('/loadtitle', 'QuestionController@loadTitle')->name('load-title');

        Route::get('/get-question', 'QuestionController@getQuestion')->name('get-question');

        # Survey template
        Route::get('/surveytemplate', 'AdminController@surveyTemplateManager')->name('admin-survey-template');

        Route::get('/get-template', 'SurveyController@getTemplate')->name('get-template');

        Route::get('/getalltemplate', 'SurveyController@getAllTemplate')->name('get-all-template');

        Route::get('/load-template', 'SurveyController@loadTemplate')->name('load-template');

        Route::post('/create-template', 'SurveyController@createTemplate')->name('create-template');

        Route::post('/set-default', 'SurveyController@setDefaultTemplate')->name('set-default-template');

        Route::post('/update-template', 'SurveyController@updateTemplate')->name('update-template');

        Route::post('/delete-template', 'SurveyController@deleteTemplate')->name('delete-template');

        Route::post('/remove-question', 'SurveyController@removeQuestion')->name('remove-question');

        Route::post('/add-question', 'SurveyController@addQuestion')->name('add-question');

        Route::get('/load-question', 'SurveyController@loadQuestion')->name('load-question');

        Route::get('/survey', 'AdminController@surveyManager')->name('admin-survey');

        # Survey
        Route::get('/search-class', 'AdminController@searchClass')->name('search-class');

        Route::post('/import-class', 'ClassController@importClass')->name('import-class');

        Route::post('/delete-class', 'ClassController@deleteClass')->name('delete-class');

        Route::post('/delete-class-all', 'ClassController@deleteAllClass')->name('delete-all');

        Route::post('/change-template', 'ClassController@changeTemplate')->name('change-template');

        Route::post('/generate-class', 'ClassController@generateClass')->name('generate-class');

        Route::get('/getallclasses', 'ClassController@getAllClass')->name('get-all-class');
    });

});
