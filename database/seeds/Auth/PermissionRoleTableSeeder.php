<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
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

        // Create Roles
        $admin = Role::create(['name' => config('access.users.admin_role')]);
//        $executive = Role::create(['name' => 'executive']);
        $proctor = Role::create(['name' => config('access.users.proctor_role')]);
        $quiz_maker = Role::create(['name' => config('access.users.quiz_maker_role')]);
        $curator = Role::create(['name' => config('access.users.curator_role')]);
        $teacher = Role::create(['name' => config('access.users.teacher_role')]);
        $student = Role::create(['name' => config('access.users.student_role')]);
        $user = Role::create(['name' => config('access.users.default_role')]);

        // Create Permissions
        $permissions = config('access.permissions.permissions_list');

        foreach ($permissions as $permission => $name) {
            Permission::create(['name' => $name]);
        }

        // ALWAYS GIVE ADMIN ROLE ALL PERMISSIONS
        $admin->givePermissionTo(Permission::all());

        // Assign Permissions to other Roles
//        $executive->givePermissionTo('view backend');
        $proctor->givePermissionTo(config('access.permissions.permissions_list')['export_result']);
        $quiz_maker->givePermissionTo(config('access.permissions.permissions_list')['modify_quizs']);
        $curator->givePermissionTo(config('access.permissions.permissions_list')['set_quiz_num']);
        $student->givePermissionTo(config('access.permissions.permissions_list')['join_quizs']);
        $this->enableForeignKeys();
    }
}
