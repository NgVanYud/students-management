<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/20/2018
 * Time: 12:15 AM
 */

Route::group([
    'as' => 'student.',
    'prefix' => 'student',
    'namespace' => 'Student'
], function() {
    Route::get('{user}/{examination}/join-test', 'StudentController@joinTest')->name('join_test');
    Route::post('{user}/{examination}/submit-test', 'StudentController@submitTest')->name('submit_test');
});