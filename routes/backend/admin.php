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
        Route::get('{subject}/inactive', 'SubjectStatusController@inactive')->name('inactive');
        Route::get('{subject}/active', 'SubjectStatusController@active')->name('active');
        Route::get('{subject}/restore', 'SubjectStatusController@restore')->name('restore');
        Route::get('deleted', 'SubjectStatusController@getDeleted')->name('deleted');
        Route::get('{subject}/delete-per', 'SubjectStatusController@delete')->name('delete-permanently');
    });

    /*
     * Subject CRUD
     */
    Route::get('subject/{subject}/{tab_type?}', 'SubjectController@show')->name('subject.show');
    Route::resource('subject', 'SubjectController', [
        'parameters' => 'singular'
    ])->except(['show']);
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
    Route::get('subject/{subject}/chapter/create/{is_chapter?}', 'ChapterController@create')
        ->name('subject.chapter.create');

    Route::resource('subject.chapter', 'ChapterController')->except([
        'create'
    ]);
});
