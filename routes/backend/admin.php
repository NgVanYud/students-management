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
    'middleware' => 'teacher'

], function () {
    Route::group([
        'prefix' => 'subject',
        'as' => 'subject.',
        'middleware' => 'admin'
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
    Route::group([
        'middleware' => 'admin'
    ], function() {
        Route::resource('subject', 'SubjectController', [
            'parameters' => 'singular'
        ])->except(['show', 'index']);
    });


    Route::resource('subject', 'SubjectController', [
        'parameters' => 'singular'
    ])->only(['index']);

    Route::get('subject/{subject}/{tab_type?}', 'SubjectController@show')
        ->name('subject.show');
});

/**
 * Lecturer
 */
Route::group([
    'namespace' => 'Subject',
    'prefix'    => 'lecturer',
    'middleware' => 'admin'
], function () {

    Route::get('total', 'LecturerController@total')->name('lecturer.total');
    Route::resource('subject.lecturer', 'LecturerController')->except(['show']);
});

/*
 * Chapter
 */

Route::group([
   'namespace' => 'Subject',
    'middleware' => 'teacher'
], function () {

    Route::group([
        'prefix' => 'subject/{subject}/chapter',
        'as' => 'subject.chapter.',
        'middleware' => 'quiz_maker'
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
    Route::resource('subject.chapter', 'ChapterController')->except(['index'])->middleware('quiz_maker');
});

/**
 * Question
 */

Route::group([
    'namespace' => 'Question',
    'middleware' => 'quiz_maker'
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
    Route::post('question', 'QuestionController@store')->name('chapter.question.store');

    Route::resource('chapter.question', 'QuestionController')->except(['index', 'create', 'store', 'show']);
});

/**
 * Examination
 */

Route::group([
   'namespace' => 'Examination',
    'middleware' => 'teacher'
], function() {
    Route::group([
        'as' => 'examination.',
        'prefix' => 'examination',
        'middleware' => 'admin'
    ], function() {
        Route::get('{examination}/inactive', 'ExaminationStatusController@inactive')->name('inactive');
        Route::get('{examination}/active', 'ExaminationStatusController@active')->name('active');
        Route::get('{examination}/restore', 'ExaminationStatusController@restore')->name('restore');

    });
    Route::resource('examination', 'ExaminationController')
        ->except([
            'edit',
            'update'
        ])
        ->only([
            'index'
        ]);

    Route::resource('examination', 'ExaminationController')
        ->except([
            'edit',
            'update'
        ])
        ->only([
            'destroy', 'store', 'create'
        ])
        ->middleware('admin');

    Route::resource('examination', 'ExaminationController')
        ->only([
            'show'
        ])
        ->middleware('quiz_maker');


    Route::group([
        'as' => 'examination.',
        'prefix' => 'examination',
        'middleware' => 'admin',
    ], function() {
        /**
         * Edit, update
         */
        Route::get('{examination}/edit/{tab_type?}', 'ExaminationController@edit')
            ->name('edit');
        Route::post('{examination}/edit/general-info', 'ExaminationController@updateGeneralInfo')
            ->name('general_info.update');
        Route::post('{examination}/edit/proctor', 'ExaminationController@updateProctors')
            ->name('proctor.update');
        Route::post('{examination}/edit/student', 'ExaminationController@updateStudents')
            ->name('student.update');
    });

    /**
     * Format test
     */
    Route::group([
        'middleware' => 'quiz_maker'
    ], function() {
        Route::get('examination/{examination}/format-test', 'ExaminationController@formatTest')
            ->name('examination.format_test');
        Route::post('examination/{examination}/format-test', 'ExaminationController@storeFormatTest')
            ->name('examination.store_format_test');
    });

    /**
     * Number of tests
     */
    Route::group([
        'middleware' => 'curator'
    ], function() {
        Route::get('examination/{examination}/test-num', 'ExaminationController@createTestNum')
            ->name('examination.create_test_num');
        Route::post('examination/{examination}/test-num', 'ExaminationController@storeTests')
            ->name('examination.store_test');
    });


    /**
     * Publish
     */
    Route::get('examination/{examination}/publish', 'ExaminationStatusController@publish')
        ->name('examination.publish')->middleware(['proctor']);


//    Route::get('examination/{examination}/student/{student}', 'ExaminationController@deleteStudent');
});

/*
 *
 */
Route::group([
    'namespace' => 'Examination'
], function() {
    Route::group([
        'as' => 'test.',
        'prefix' => 'test'
    ], function() {

    });
    Route::resource('{examination}/test', 'TestController');
});