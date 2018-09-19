<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTestNumIntoExaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumns('examinations', ['test_num'])) {
            Schema::table('examinations', function(Blueprint $table) {
                $table->tinyInteger('test_num')->default(0);
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
        if(Schema::hasColumns('examinations', ['test_num'])) {
            Schema::table('examinations', function(Blueprint $table) {
                $table->dropColumn(['test_num']);
            });
        }
    }
}
