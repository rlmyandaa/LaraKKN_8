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

Route::group(['prefix' => 'student', 'middleware' => ['auth', 'activated', 'role:student|admin', 'activity', 'twostep', 'checkblocked']], function () {
    Route::get('/', 'StudentController@index')->name('student.home');

    /*
    |--------------------------------------------------------------------------
    | Profile Routes
    |--------------------------------------------------------------------------
    */
    Route::group([], function () {
        Route::get('/profile', 'ProfileController@index')->name('student.profile');
        Route::post('/profile/store', 'ProfileController@store')->name('student.profile-store');
        Route::get('/profile/edit', 'ProfileController@edit')->name('student.profile-edit');
        Route::post('/profile/update', 'ProfileController@update')->name('student.profile-update');
    });

    /*
    |--------------------------------------------------------------------------
    | Group Routes
    |--------------------------------------------------------------------------
    | 
    */
    Route::group([], function () {
        Route::get('/group', 'GroupController@index')->name('student.group');
        Route::post('/group/token-update', 'GroupController@token_update')->name('student.group-token-update');
    });

    /*
    |--------------------------------------------------------------------------
    | Proker-Propose Routes
    |--------------------------------------------------------------------------
    */
    Route::group([], function () {
        Route::get('/proker', 'ProkerController@index')->name('student.proker');
        Route::get('/proker/propose', 'ProkerProposeController@propose')->name('student.proker-propose');
        Route::post('/proker/propose/upload', 'ProkerProposeController@propose_upload')->name('student.proker-propose-upload');
        Route::get('/proker/propose/formatproker', 'ProkerProposeController@getFormatProker')->name('student.proker-getFormatProker');
        Route::get('/proker/list', 'ProkerController@list')->name('student.proker-list');
        //cancel pending proposal
        Route::get('/proker/list/prm/{id}', 'ProkerController@list_pending_remove')->name('student.proker-list-pending-remove');
        Route::get('/proker/dlp/{id}', 'ProkerController@getFilePending')->name('student.proker-getFilePending');
        Route::get('/proker/dla/{id}', 'ProkerController@getFileAcc')->name('student.proker-getFileAcc');
        Route::get('/proker/dlr/{id}', 'ProkerController@getFileReject')->name('student.proker-getFileReject');

    });


    /*
    |--------------------------------------------------------------------------
    | Proker-Daily Report Routes
    |--------------------------------------------------------------------------
    */
    Route::group([], function () {
        Route::get('/proker/daily-report', 'DailyReportController@index')->name('student.proker-daily_report');
        Route::get('/proker/daily-report/add', 'DailyReportController@add')->name('student.proker-daily_report-add');
        Route::post('/proker/daily-report/upload', 'DailyReportController@upload')->name('student.proker-daily_report-upload');
        Route::get('/proker/daily-report/detail/{id}', 'DailyReportController@detail')->name('student.proker-daily_report-detail');
        Route::get('/proker/daily-report/detail/file/{id}', 'DailyReportController@getFile')->name('student.proker-daily_report-getFile');
        Route::get('/proker/daily-report/delete/{id}', 'DailyReportController@delete')->name('student.proker-daily_report-delete');
    });


    /*
    |--------------------------------------------------------------------------
    | Proker-Final Report Routes
    |--------------------------------------------------------------------------
    */
    Route::group([], function () {
        Route::get('/proker/final-report', 'FinalReportController@status')->name('student.proker-final_report');
        Route::get('/proker/final-report/submission', 'FinalReportController@submission')->name('student.proker-final_report-submission');
        Route::post('/proker/final-report/submission/upload', 'FinalReportController@submission_upload')->name('student.proker-final_report-submission_upload');

        Route::get('/proker/final-report/detail', 'FinalReportController@detail')->name('student.proker-final_report-detail');

        Route::get('/proker/final-report/revisi', 'FinalReportController@revision')->name('student.proker-final_report-revision');
        Route::get('/proker/final-report/revisi/detail/{id}', 'FinalReportController@revision_detail')->name('student.proker-final_report-revision-detail');
        Route::post('/proker/final-report/revisi/submit', 'FinalReportController@revision_submit')->name('student.proker-final_report-revision_submit');

        Route::get('/proker/final-report/final_submission', 'FinalReportController@final_submission')->name('student.proker-final_report-final_submission');

        Route::get('/proker/final-report/dl/{id}', 'FinalReportController@getFile')->name('student.proker-final_report-getFile');

        Route::post('/proker/final-report/final-submission/submit', 'FinalReportController@final_submission_submit')->name('student.proker-final_report-final_submission-submit');
    });
});
