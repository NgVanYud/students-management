<?php

use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    use DisableForeignKeys;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        factory(\App\Models\Auth\User::class, 1500)->create()->each(function($student) {
            $student->assignRole(config('access.users.student_role'));
        });
        $this->enableForeignKeys();
    }
}
