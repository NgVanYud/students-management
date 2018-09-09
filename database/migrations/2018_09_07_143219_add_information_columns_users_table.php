<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInformationColumnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('access.table_names.users'), function (Blueprint $table) {
            $table->tinyInteger('gender')->default(\App\Models\Auth\User::FEMALE_CODE);
            $table->string('identity', 20)->index();
            $table->string('code', 30)->index();
            $table->string('city', 20)->nullable();
            $table->string('ethnic', 20)->nullable();
            $table->string('nation', 20)->nullable();
            $table->string('phone_number', 11)->nullable();
            $table->date('birthday');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('access.table_names.users'), function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'identity',
                'code',
                'city',
                'ethnic',
                'nation',
                'phone_number',
                'birthday'
            ]);
        });
    }
}
