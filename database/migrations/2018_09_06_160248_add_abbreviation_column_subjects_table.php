<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAbbreviationColumnSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!\Schema::hasColumn('subjects', 'abbreviation')) {
            Schema::table('subjects', function (Blueprint $table) {
                $table->string('abbreviation', 10);
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
        if(Schema::hasColumn('subjects', 'abbreviation')) {
            Schema::table('subjects', function (Blueprint $table) {
                $table->dropColumn('abbreviation');
            });
        }
    }
}
