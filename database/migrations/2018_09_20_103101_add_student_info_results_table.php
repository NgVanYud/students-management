<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentInfoResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumns('results', ['read_at', 'timeout', 'status'])) {
            Schema::table('results', function(Blueprint $table) {
                $table->dateTime('read_at')->nullable();
                $table->integer('timeout')->nullable();
                $table->tinyInteger('status')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasColumns('results', ['read_at', 'timeout', 'status'])) {
            Schema::table('results', function (Blueprint $table) {
                $table->dropColumn(['read_at', 'timeout', 'status']);
            });
        }
    }
}
