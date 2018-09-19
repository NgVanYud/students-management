<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Alert Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain alert messages for various scenarios
    | during CRUD operations. You are free to modify these language lines
    | according to your application's requirements.
    |
    */

    'backend' => [
        'roles' => [
            'created' => 'The role was successfully created.',
            'deleted' => 'The role was successfully deleted.',
            'updated' => 'The role was successfully updated.',
        ],

        'users' => [
            'cant_resend_confirmation' => 'The application is currently set to manually approve users.',
            'confirmation_email' => 'A new confirmation e-mail has been sent to the address on file.',
            'confirmed' => 'The user was successfully confirmed.',
            'created' => 'The user was successfully created.',
            'deleted' => 'The user was successfully deleted.',
            'deleted_permanently' => 'The user was deleted permanently.',
            'restored' => 'The user was successfully restored.',
            'session_cleared' => "The user's session was successfully cleared.",
            'social_deleted' => 'Social Account Successfully Removed',
            'unconfirmed' => 'The user was successfully un-confirmed',
            'updated' => 'The user was successfully updated.',
            'updated_password' => "The user's password was successfully updated.",
        ],
        'subjects' => [
            'created' => 'The subject was successfully created.',
            'deleted' => 'The subject was successfully deleted.',
            'updated' => 'The subject was successfully updated.',
            'actived' => 'The subject was successfully actived.',
            'inactived' => 'The subject was successfully inactived.',
            'restored' => 'The subject was successfully restored.',

            'chapters' => [
                'created' => 'The chapter was successfully created.',
                'deleted' => 'The chapter was successfully deleted.',
                'updated' => 'The chapter was successfully updated.',
                'actived' => 'The chapter was successfully actived.',
                'inactived' => 'The chapter was successfully inactived.',
                'restored' => 'The chapter was successfully restored.',
            ],

            'lecturers' => [
                'invalid_lecturers'     => 'The lecturers are selected not invalid.',
                'added'                 => 'The lecturers was successfully added.',
                'deleted' => 'The lecturer was successfully deleted.',
                'undeleted' => 'The lecturer was not deleted because of some errors.',
                'updated' => 'The lecturer was successfully updated.',
                'actived' => 'The lecturer was successfully actived.',
                'inactived' => 'The lecturer was successfully inactived.',
                'restored' => 'The lecturer was successfully restored.',
            ],
        ],

        'questions' => [
            'created' => 'The question was successfully created.',
            'uncreated' => 'The question was not created because of some errors.',
            'deleted' => 'The question was successfully deleted.',
            'updated' => 'The question was successfully updated.',
            'unupdated' => 'The question was not updated because of some errors.',
            'actived' => 'The question was successfully actived.',
            'inactived' => 'The question was successfully inactived.',
            'restored' => 'The question was successfully restored.',
        ],

        'examinations' => [
            'created' => 'The examination was successfully created.',
            'created_general_info' => 'The general information of examination was successfully created.',
            'created_proctors' => 'The proctors of examination was successfully created.',
            'created_students' => 'The students of examination was successfully created.',
            'uncreated' => 'The examination was not created because of some errors in file excel. Please check it.',
            'uncreated_proctors' => 'The proctors of examination was not created because of some errors in file excel. Please check it.',
            'uncreated_students' => 'The students of examination was not created because of some errors in file excel. Please check it.',
            'unupdated_general_info' => 'The general information of examination was not created because of some errors.',
            'unupdated_proctors' => 'The proctors of examination was not created because of some errors in file excel. Please check it.',
            'unupdated_students' => 'The students of examination was not created because of some errors in file excel. Please check it.',
            'deleted' => 'The examination was successfully deleted.',
            'updated' => 'The examination was successfully updated.',
            'updated_general_info' => 'The general information of examination was successfully updated.',
            'updated_proctors' => 'The proctors of examination was successfully updated.',
            'updated_students' => 'The students of examination was successfully updated.',
            'unupdated' => 'The examination was not updated because of some errors.',
            'actived' => 'The examination was successfully actived.',
            'inactived' => 'The examination was successfully inactived.',
            'restored' => 'The examination was successfully restored.',
            'create_format_test' => 'The format of the test was successfully create.',
            'update_format_test' => 'The format of the test was successfully update.',
            'create_test_num' => 'The number of the test was successfully update.',
            'uncreate_test_num' => 'The number of the test was not successfully update beacause of some errors.',
        ],

    ],

    'frontend' => [
        'contact' => [
            'sent' => 'Your information was successfully sent. We will respond back to the e-mail provided as soon as we can.',
        ],
    ],
];
