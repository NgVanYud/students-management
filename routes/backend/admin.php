<?php

/**
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', 'DashboardController@index')->name('dashboard');

/*
 * Subject
 */
Route::group([
    'namespace' => 'Subject',
], function () {

    Route::group([
        'prefix' => 'subject',
        'as' => 'subject.'
    ], function () {
        /*
         * Status subject
         */
        Route::get('{subject}/inactive', 'SubjectStatusController@inactive')->name('inactive');
        Route::get('{subject}/active', 'SubjectStatusController@active')->name('active');
        Route::get('{subject}/restore', 'SubjectStatusController@restore')->name('restore');
        Route::get('deleted', 'SubjectStatusController@getDeleted')->name('deleted');
        Route::get('{subject}/delete-per', 'SubjectStatusController@delete')->name('delete-permanently');
    });

    /*
     * Subject CRUD
     */
    Route::resource('subject', 'SubjectController', [
        'parameters' => 'singular'
    ])->except(['show']);
    Route::get('subject/{subject}/{tab_type?}', 'SubjectController@show')
        ->name('subject.show');
});

/**
 * Lecturer
 */
Route::group([
    'namespace' => 'Subject',
    'prefix'    => 'lecturer'
], function () {

    Route::get('total', 'LecturerController@total')->name('lecturer.total');
    Route::resource('subject.lecturer', 'LecturerController')->except(['show']);
});

/*
 * Chapter
 */

Route::group([
   'namespace' => 'Subject'
], function () {

    Route::group([
        'prefix' => 'subject/{subject}/chapter',
        'as' => 'subject.chapter.'
    ], function () {
        Route::get('{chapter}/inactive', 'ChapterStatusController@inactive')->name('inactive');
        Route::get('{chapter}/active', 'ChapterStatusController@active')->name('active');
        Route::get('{chapter}/restore', 'ChapterStatusController@restore')->name('restore');
//        Route::get('deleted', 'SubjectStatusController@getDeleted')->name('deleted');
        Route::get('{chapter}/delete-per', 'ChapterStatusController@delete')->name('delete-permanently');
    });

    /*
     * CRUD
     */
    Route::resource('subject.chapter', 'ChapterController')->except(['index']);
});

/**
 * Question
 */

Route::group([
    'namespace' => 'Question'
], function(){
    Route::group([
        'as' => 'question.'
    ], function() {
        /*
     * Active, inactive
     */
        Route::get('{question}/inactive', 'QuestionController@inactive')->name('inactive');
        Route::get('{question}/active', 'QuestionController@active')->name('active');
        Route::get('{question}/restore', 'QuestionController@restore')->name('restore');
        Route::get('deleted', 'QuestionController@getDeleted')->name('deleted');
    });

    Route::get('chapter/question', 'QuestionController@index')->name('chapter.question.index');
//    Route::post('{chapter}/question', 'QuestionController@show')->name('chapter.question.show');
    Route::get('question/create', 'QuestionController@create')->name('chapter.question.create');
    Route::post('question ', 'QuestionController@store')->name('chapter.question.store');

    Route::resource('chapter.question', 'QuestionController')->except(['index', 'create', 'store', 'show']);
});

/**
 * Examination
 */

Route::group([
   'namespace' => 'Examination',
], function() {
    Route::group([
        'as' => 'examination.',
        'prefix' => 'examination'
    ], function() {
        Route::get('{examination}/inactive', 'ExaminationStatusController@inactive')->name('inactive');
        Route::get('{examination}/active', 'ExaminationStatusController@active')->name('active');
        Route::get('{examination}/restore', 'ExaminationStatusController@restore')->name('restore');
    });
    Route::resource('examination', 'ExaminationController')->except([
        'edit', 'update'
    ]);

    Route::get('examination/{examination}/edit/{tab_type?}', 'ExaminationController@edit')
        ->name('examination.edit');
    Route::post('examination/{examination}/edit/general-info', 'ExaminationController@updateGeneralInfo')
        ->name('examination.general_info.update');
    Route::post('examination/{examination}/edit/proctor', 'ExaminationController@updateProctors')
        ->name('examination.proctor.update');
    Route::post('examination/{examination}/edit/student', 'ExaminationController@updateStudents')
        ->name('examination.student.update');
    Route::get('examination/{examination}/format-test', 'ExaminationController@formatTest')
        ->name('examination.format_test');
    Route::post('examination/{examination}/format-test', 'ExaminationController@storeFormatTest')
        ->name('examination.store_format_test');
//    Route::get('examination/{examination}/student/{student}', 'ExaminationController@deleteStudent');
});

/*
 *
 */
Route::group([
    'namespace' => 'Examination',
], function() {
    Route::group([
        'as' => 'test.',
        'prefix' => 'test'
    ], function() {

    });
    Route::resource('{examination}/test', 'TestController');
});