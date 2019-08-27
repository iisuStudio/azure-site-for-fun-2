<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateQueryToTrackerQueries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracker_queries', function (Blueprint $table) {
            //
            $table->dropIndex('tracker_queries_query_index');
            $table->string('query', 2000)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tracker_queries', function (Blueprint $table) {
            //
            //$table->string('query')->change();
        });
    }
}
