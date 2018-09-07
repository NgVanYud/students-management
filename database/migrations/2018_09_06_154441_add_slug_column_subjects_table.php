<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugColumnSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!\Schema::hasColumn('subjects', 'slug')) {
            Schema::table('subjects', function (Blueprint $table) {
               $table->string('slug');
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
        if(Schema::hasColumn('subjects', 'slug')) {
            Schema::table('subjects', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
}
