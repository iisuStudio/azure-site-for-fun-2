<?php

use Illuminate\Database\Schema\Blueprint;
use PragmaRX\Tracker\Support\Migration;

class AddTrackerRefererColumnToLog extends Migration
{
    /**
     * Table related to this migration.
     *
     * @var string
     */
    private $table = 'tracker_log';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function migrateUp()
    {
        $this->builder->table(
            $this->table,
            function ($table) {
                $table->integer('referer_id')->unsigned()->nullable()->index();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function migrateDown()
    {
//        $this->builder->table(
//            $this->table,
//            function ($table) {
//                $table->dropColumn('referer_id');
//            }
//        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropIndex('tracker_log_referer_id_index');
            $table->dropColumn('referer_id');
        });
    }
}
