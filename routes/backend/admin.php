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
    Route::resource('subject', 'SubjectController', [
        'parameters' => 'singular'
    ]);
});

