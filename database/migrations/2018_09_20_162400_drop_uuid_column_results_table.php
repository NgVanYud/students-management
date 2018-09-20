<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropUuidColumnResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumns('results', ['uuid'])) {
            Schema::table('results', function(Blueprint $table) {
                $table->dropColumn(['uuid']);
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
        if(!Schema::hasColumns('results', ['uuid'])) {
            Schema::table('results', function(Blueprint $table) {
                $table->uuid('uuid')->nullable();
            });
        }
    }
}
