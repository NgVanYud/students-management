<?php

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

/**
 * Class UserRoleTableSeeder.
 */
class UserRoleTableSeeder extends Seeder
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

        User::find(1)->assignRole(config('access.users.admin_role'));
        User::find(2)->assignRole(config('access.users.proctor_role'));
        User::find(3)->assignRole(config('access.users.quiz_maker_role'));
        User::find(4)->assignRole(config('access.users.curator_role'));
        User::find(5)->assignRole(config('access.users.teacher_role'));
        User::find(6)->assignRole(config('access.users.student_role'));
        User::find(7)->assignRole(config('access.users.default_role'));

        $this->enableForeignKeys();
    }
}
