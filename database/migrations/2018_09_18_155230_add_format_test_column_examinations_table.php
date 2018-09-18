<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFormatTestColumnExaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumns('examinations', ['format_test', 'question_num'])) {
            Schema::table('examinations', function(Blueprint $table) {
                $table->longText('format_test')->nullable();
                $table->integer('question_num')->default(0);
                $table->integer('timeout')->default(0);
                $table->tinyInteger('is_published')->default(0);
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
        if(Schema::hasColumns('examinations', ['format_test', 'question_num'])) {
            Schema::table('examinations', function(Blueprint $table) {
                $table->dropColumn(['format_test', 'question_num', 'timeout', 'is_published']);
            });
        }
    }
}
