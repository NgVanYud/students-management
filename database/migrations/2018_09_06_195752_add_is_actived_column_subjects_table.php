<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsActivedColumnSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('subjects', 'is_actived')) {
            Schema::table('subjects', function (Blueprint $table) {
                $table->tinyInteger('is_actived')->default(\App\Models\Subject::INACTIVE_CODE);
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
        if(Schema::hasColumn('subjects', 'is_actived')) {
            Schema::table('subjects', function (Blueprint $table) {
                $table->dropColumn('is_actived');
            });
        }
    }
}
