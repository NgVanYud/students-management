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
    ],

    'frontend' => [
        'contact' => [
            'sent' => 'Your information was successfully sent. We will respond back to the e-mail provided as soon as we can.',
        ],
    ],
];
