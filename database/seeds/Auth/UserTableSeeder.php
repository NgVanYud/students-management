<?php

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Add the master administrator, user id of 1
        User::create([
            'first_name'        => 'Admin',
            'last_name'         => 'Istrator',
            'email'             => 'admin@admin.com',
            'password'          => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
            'username'         => 'ADMIN_01'
        ]);

        //Giám thị id = 2
        User::create([
            'first_name'        => 'Proctor',
            'last_name'         => 'User',
            'email'             => 'proctor@proctor.com',
            'password'          => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
            'username'          => 'PROCTOR_01'
        ]);

        //Người ra đề
        User::create([
            'first_name'        => 'Quiz Maker',
            'last_name'         => 'User',
            'email'             => 'quizmaker@quizmaker.com',
            'password'          => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
            'username'          => 'QUIZ_MAKER_01'
        ]);

        //Giáo phụ khoa
        User::create([
            'first_name'        => 'Curator',
            'last_name'         => 'User',
            'email'             => 'curator@curator.com',
            'password'          => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
            'username'          => 'CURATOR_01'
        ]);

        //Giáo viên (chưa có vai trò)
        User::create([
            'first_name'        => 'Teacher',
            'last_name'         => 'User',
            'email'             => 'teacher@teacher.com',
            'password'          => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
            'username'          => 'TEACHER_01'
        ]);

        //Sinh viên
        User::create([
            'first_name'        => 'Student',
            'last_name'         => 'User',
            'email'             => 'student@student.com',
            'password'          => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
            'username'          => 'AT110415'
        ]);

        //User thông thường
        User::create([
            'first_name'        => 'Default',
            'last_name'         => 'User',
            'email'             => 'user@user.com',
            'password'          => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
            'username'          => 'USER_01'
        ]);

        $this->enableForeignKeys();
    }
}
