<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Labels Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in labels throughout the system.
    | Regardless where it is placed, a label can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'general' => [
        'all'     => 'All',
        'yes'     => 'Yes',
        'no'      => 'No',
        'copyright' => 'Copyright',
        'custom'  => 'Custom',
        'actions' => 'Actions',
        'active'  => 'Active',
        'buttons' => [
            'save'   => 'Save',
            'update' => 'Update',
        ],
        'hide'              => 'Hide',
        'inactive'          => 'Inactive',
        'none'              => 'None',
        'show'              => 'Show',
        'toggle_navigation' => 'Toggle Navigation',
    ],

    'backend' => [
        'access' => [
            'roles' => [
                'create'     => 'Create Role',
                'edit'       => 'Edit Role',
                'management' => 'Role Management',

                'table' => [
                    'number_of_users' => 'Number of Users',
                    'permissions'     => 'Permissions',
                    'role'            => 'Role',
                    'sort'            => 'Sort',
                    'total'           => 'role total|roles total',
                ],
            ],

            'users' => [
                'active'              => 'Active Users',
                'all_permissions'     => 'All Permissions',
                'change_password'     => 'Change Password',
                'change_password_for' => 'Change Password for :user',
                'create'              => 'Create User',
                'deactivated'         => 'Deactivated Users',
                'deleted'             => 'Deleted Users',
                'edit'                => 'Edit User',
                'management'          => 'User Management',
                'no_permissions'      => 'No Permissions',
                'no_roles'            => 'No Roles to set.',
                'permissions'         => 'Permissions',

                'table' => [
                    'confirmed'      => 'Confirmed',
                    'created'        => 'Created',
                    'email'          => 'E-mail',
                    'id'             => 'ID',
                    'last_updated'   => 'Last Updated',
                    'name'           => 'Name',
                    'first_name'     => 'First Name',
                    'last_name'      => 'Last Name',
                    'no_deactivated' => 'No Deactivated Users',
                    'no_deleted'     => 'No Deleted Users',
                    'other_permissions' => 'Other Permissions',
                    'permissions'       => 'Permissions',
                    'roles'             => 'Roles',
                    'social'            => 'Social',
                    'total'             => 'user total|users total',
                    'username'          => 'Username',
                    'select'            => 'Select',
                    'identity'          => 'Identity',
                    'gender'            => 'Gender',
                    'birthday'          => 'Birthday',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => 'Overview',
                        'history'  => 'History',
                    ],

                    'content' => [
                        'overview' => [
                            'avatar'       => 'Avatar',
                            'confirmed'    => 'Confirmed',
                            'created_at'   => 'Created At',
                            'deleted_at'   => 'Deleted At',
                            'email'        => 'E-mail',
                            'last_login_at' => 'Last Login At',
                            'last_login_ip' => 'Last Login IP',
                            'last_updated' => 'Last Updated',
                            'name'         => 'Name',
                            'first_name'   => 'First Name',
                            'last_name'    => 'Last Name',
                            'status'       => 'Status',
                            'timezone'     => 'Timezone',
                            'username'          => 'Username',
                            'gender'        => 'Gender',
                            'identity'      => 'Identity',
                            'nation'        => 'Nation',
                            'city'          => 'City',
                            'ethnic'        => 'Ethnic',
                            'phone_number'  => 'Phone Number',
                            'birthday'      => 'Date of birth',
                        ],
                    ],
                ],

                'view' => 'View User',
            ],
        ],

        'subjects' => [
            'all'           => 'All Subjects',
            'create'        => 'Create Subject',
            'edit'          => 'Edit Subject',
            'management'    => 'Subjects Management',
            'deleted'       => 'Deleted Subjects',
            'view'          => 'View Subject',
            'add_lecturers'  => 'Add Lecturers',

            'table' => [
                'name'          => 'Name',
                'actived'       => 'Actived',
                'abbreviation'  => 'Abbreviation',
                'credit'        => 'Credit',
                'total'         => 'subject total|subjects total'
            ],

            'tabs' => [
                'titles' => [
                    'subject' => 'Subject',
                    'history'  => 'History',
                    'chapters'   => 'Chapters',
                    'deleted_chapters'  => 'Deleted Chapters',
                    'lecturers' => 'Lecturers',
                ],

                'content' => [

                    'subject' => [
                        'credit'        => 'Credit',
                        'abbreviation'  => 'Abbreviation',
                        'actived'       => 'Actived',
                        'confirmed'    => 'Confirmed',
                        'created_at'   => 'Created At',
                        'deleted_at'   => 'Deleted At',
                        'last_updated' => 'Last Updated',
                        'name'         => 'Name',
                        'status'       => 'Status',
                        'timezone'     => 'Timezone',
                        'questions_num' => 'Questions Number',
                        'lecturers_num' => 'Lecturers Number',
                        'chapters_num' => 'Chapters Number',
                    ],

                    'chapters' => [
                        'avatar'       => 'Avatar',
                        'confirmed'    => 'Confirmed',
                        'created_at'   => 'Created At',
                        'deleted_at'   => 'Deleted At',
                        'email'        => 'E-mail',
                        'last_login_at' => 'Last Login At',
                        'last_login_ip' => 'Last Login IP',
                        'last_updated' => 'Last Updated',
                        'name'         => 'Name',
                        'first_name'   => 'First Name',
                        'last_name'    => 'Last Name',
                        'status'       => 'Status',
                        'timezone'     => 'Timezone',
                    ],
                ],
            ],

            'chapters' => [
                'all'               => 'All Chapters in Subject',
                'add'               => 'Add Chapter',
                'edit'              => 'Edit Chapter',
                'management'        => 'Chapters Management',
                'deleted'           => 'Deleted Chapter',
                'view'              => 'View Chapter',

                'table' => [
                    'name'              => 'Name',
                    'actived'           => 'Actived',
                    'question_num'      => 'Number of questions',
                    'total'             => 'chapter total|chapters total',
                    'last_updated'      => 'Last Updated',
                ],
            ],

            'lecturers' => [
                'table' => [
                    'total'                     => 'lecturer total|lecturers total',
                    'last_name'                 => 'Last Name',
                    'actived'                   => 'Actived',
                    'first_name'                => 'First Name',
                    'last_updated'              => 'Last Updated',
                    'username'                  => 'Username',
                    'role'                      => 'Role',
                ]
            ]
        ],

        'lecturers' => [
            'all'           => 'All Lecturers',
            'add'        => 'Add Lecturers',
            'edit'          => 'Edit Lecturers',
            'management'    => 'Lecturers Management',
            'deleted'       => 'Deleted Lecturers',
            'view'          => 'View Lecturers',
            'modify'        => 'Modify Lecturers',

            'table' => [
                'total'         => 'lecturer total|lecturers total',
                'name'              => 'Name',
                'actived'           => 'Actived',
                'question_num'      => 'Number of questions',
                'total'             => 'chapter total|chapters total',
                'last_updated'      => 'Last Updated',
            ]
        ],

        'questions' => [
            'all'           => 'All Question',
            'create'        => 'Create Question',
            'edit'          => 'Edit Question',
            'management'    => 'Question Management',
            'deleted'       => 'Deleted Question',
            'view'          => 'View Question',
            'modify'        => 'Modify Question',
            'list'          => 'List Questions',

            'table' => [
                'total'         => 'question total|questions total',
                'options'       => 'Options',
                'contents'       => 'Content',
                'name'              => 'Name',
                'actived'           => 'Actived',
                'question_num'      => 'Number of questions',
                'last_updated'      => 'Last Updated',
            ]
        ],

        'examinations' => [
            'all'           => 'All Examinations',
            'create'        => 'Create Examination',
            'edit'          => 'Edit Examinations',
            'management'    => 'Examinations Management',
            'deleted'       => 'Deleted Examination',
            'view'          => 'View Examination',
            'modify'        => 'Modify Examinations',
            'list'          => 'List Examinations',
            'format_test'          => 'Format Test',
            'test_num'          => 'Number of Test',
            'result'          => 'Result',

            'table' => [
                'total'         => 'examination total|examinations total',
                'all'           => 'All',
                'num'           => 'Num',
                'student_name'           => 'Name',
                'test'           => 'Test Code',
                'score'           => 'Score',
                'students_num'       => 'Num of Students',
                'proctors_num'       => 'Num of Proctors',
                'proctors_students_tests_questions_time'       => 'Proc/Stds/Test/Ques/Time',
                'options'           => 'Options',
                'name'              => 'Name',
                'code'              => 'Code',
                'begin_time'              => 'Begin Time',
                'actived'           => 'Actived',
                'published'         => 'Published',
                'subject'           => 'Subject',
                'question_num'      => 'Number of questions',
                'last_updated'      => 'Last Updated',
            ],

            'tabs' => [
                'titles' => [
                    'general_info' => 'General Information',
                    'proctors'  => 'Proctors',
                    'students'   => 'Students',
                ],
            ],

            'tests' => [
                'list'          => 'List Tests',
                'format_test'   => 'Format Test',
                'test_num'      => 'Number of Test',
            ],
        ],
    ],

    'frontend' => [

        'auth' => [
            'login_box_title'    => 'Login',
            'login_button'       => 'Login',
            'login_with'         => 'Login with :social_media',
            'register_box_title' => 'Register',
            'register_button'    => 'Register',
            'remember_me'        => 'Remember Me',
        ],

        'contact' => [
            'box_title' => 'Contact Us',
            'button' => 'Send Information',
        ],

        'passwords' => [
            'expired_password_box_title' => 'Your password has expired.',
            'forgot_password'                 => 'Forgot Your Password?',
            'reset_password_box_title'        => 'Reset Password',
            'reset_password_button'           => 'Reset Password',
            'update_password_button'           => 'Update Password',
            'send_password_reset_link_button' => 'Send Password Reset Link',
        ],

        'user' => [
            'passwords' => [
                'change' => 'Change Password',
            ],

            'profile' => [
                'avatar'             => 'Avatar',
                'created_at'         => 'Created At',
                'edit_information'   => 'Edit Information',
                'email'              => 'E-mail',
                'last_updated'       => 'Last Updated',
                'name'               => 'Name',
                'first_name'         => 'First Name',
                'last_name'          => 'Last Name',
                'update_information' => 'Update Information',
            ],
        ],

    ],
];
