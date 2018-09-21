<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Exception Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in Exceptions thrown throughout the system.
    | Regardless where it is placed, a button can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'general' => [
        'not_permission' => 'You are not granted permission.'
    ],

    'backend' => [
        'access' => [
            'roles' => [
                'already_exists'    => 'That role already exists. Please choose a different name.',
                'cant_delete_admin' => 'You can not delete the Administrator role.',
                'create_error'      => 'There was a problem creating this role. Please try again.',
                'delete_error'      => 'There was a problem deleting this role. Please try again.',
                'has_users'         => 'You can not delete a role with associated users.',
                'needs_permission'  => 'You must select at least one permission for this role.',
                'not_found'         => 'That role does not exist.',
                'update_error'      => 'There was a problem updating this role. Please try again.',
            ],

            'users' => [
                'already_confirmed'    => 'This user is already confirmed.',
                'cant_confirm' => 'There was a problem confirming the user account.',
                'cant_deactivate_self'  => 'You can not do that to yourself.',
                'cant_delete_admin'  => 'You can not delete the super administrator.',
                'cant_delete_self'      => 'You can not delete yourself.',
                'cant_delete_own_session' => 'You can not delete your own session.',
                'cant_restore'          => 'This user is not deleted so it can not be restored.',
                'cant_unconfirm_admin' => 'You can not un-confirm the super administrator.',
                'cant_unconfirm_self' => 'You can not un-confirm yourself.',
                'create_error'          => 'There was a problem creating this user. Please try again.',
                'delete_error'          => 'There was a problem deleting this user. Please try again.',
                'delete_first'          => 'This user must be deleted first before it can be destroyed permanently.',
                'email_error'           => 'That email address belongs to a different user.',
                'mark_error'            => 'There was a problem updating this user. Please try again.',
                'not_confirmed'            => 'This user is not confirmed.',
                'not_found'             => 'That user does not exist.',
                'restore_error'         => 'There was a problem restoring this user. Please try again.',
                'role_needed_create'    => 'You must choose at lease one role.',
                'role_needed'           => 'You must choose at least one role.',
                'session_wrong_driver'  => 'Your session driver must be set to database to use this feature.',
                'social_delete_error' => 'There was a problem removing the social account from the user.',
                'update_error'          => 'There was a problem updating this user. Please try again.',
                'update_password_error' => 'There was a problem changing this users password. Please try again.',
            ],
        ],

        'subjects' => [
            'already_actived'       => 'This subject is already actived.',
            'cant_active'           => 'There was a problem activing the subject.',
            'not_actived'           => 'This subject is not actived.',
            'cant_inactive'         => 'There was a problem inactiving the subject',
            'delete_first'          => 'This subject must be deleted first before it can be destroyed permanently.',
            'cant_restore'          => 'This subject is not deleted so it can not be restored.',
            'restore_error'         => 'There was a problem restoring this subject. Please try again.',

            'chapters' => [
                'already_actived'                           => 'This chapter is already actived.',
                'cant_active'                               => 'There was a problem activing the chapter.',
                'not_actived'                               => 'This chapter is not actived.',
                'cant_inactive'                             => 'There was a problem inactiving the chapter',
                'delete_first'                              => 'This chapter must be deleted first before it can be destroyed permanently.',
                'cant_restore'                              => 'This chapter is not deleted so it can not be restored.',
                'cant_restore_for_deleted_subject'          => 'The subject contain this chapter is deleted so it can not be restored.',
                'restore_error'                             => 'There was a problem restoring this chapter. Please try again.',
                'validate_error'                            => 'There was a problem validation this new chapter',
            ],
        ],

        'questions' => [
            'already_actived'       => 'This question is already actived.',
            'cant_active'           => 'There was a problem activing the question.',
            'not_actived'           => 'This question is not actived.',
            'cant_inactive'         => 'There was a problem inactiving the question',
            'delete_first'          => 'This question must be deleted first before it can be destroyed permanently.',
            'cant_restore'          => 'This question is not deleted so it can not be restored.',
            'restore_error'         => 'There was a problem restoring this question. Please try again.',
        ],

        'examinations' => [
            'uncreated'                         => 'This examination is not created because of some errors in file excel. Please check it',
            'uncreated_proctors'             => 'The proctors of this examination is not created because of some errors in file excel. Please check it.',
            'uncreated_students'             => 'The students of this examination is not created because of some errors in file excel. Please check it.',
            'unupdated_general_info'         => 'The general information of this examination is not created because of some errors.',
            'unupdated_proctors'             => 'The proctors of this examination is not created because of some errors in file excel. Please check it.',
            'unupdated_students'             => 'The students of this examination is not created because of some errors in file excel. Please check it.',
            'already_actived'       => 'This examination is already actived.',
            'already_published'       => 'This examination is already published.',
            'cant_publish'           => 'There was a problem publishing the examination.',
            'cant_active'           => 'There was a problem activing the examination.',
            'not_actived'           => 'This examination is not actived.',
            'cant_inactive'         => 'There was a problem inactiving the examination',
            'delete_first'          => 'This examination must be deleted first before it can be destroyed permanently.',
            'cant_restore'          => 'This examination is not deleted so it can not be restored.',
            'restore_error'         => 'There was a problem restoring this examination. Please try again.',
        ],
    ],

    'frontend' => [
        'auth' => [
            'confirmation' => [
                'already_confirmed' => 'Your account is already confirmed.',
                'confirm'           => 'Confirm your account!',
                'created_confirm'   => 'Your account was successfully created. We have sent you an e-mail to confirm your account.',
                'created_pending'   => 'Your account was successfully created and is pending approval. An e-mail will be sent when your account is approved.',
                'mismatch'          => 'Your confirmation code does not match.',
                'not_found'         => 'That confirmation code does not exist.',
                'pending'            => 'Your account is currently pending approval.',
                'resend'            => 'Your account is not confirmed. Please click the confirmation link in your e-mail, or <a href=":url">click here</a> to resend the confirmation e-mail.',
                'success'           => 'Your account has been successfully confirmed!',
                'resent'            => 'A new confirmation e-mail has been sent to the address on file.',
            ],

            'deactivated' => 'Your account has been deactivated.',
            'email_taken' => 'That e-mail address is already taken.',

            'password' => [
                'change_mismatch' => 'That is not your old password.',
                'reset_problem' => 'There was a problem resetting your password. Please resend the password reset email.',
            ],

            'registration_disabled' => 'Registration is currently closed.',
        ],
    ],
];
