<?php

use Illuminate\Database\Schema\Blueprint;
use PragmaRX\Tracker\Support\Migration;

class AddLanguageIdColumnToSessions extends Migration
{
    /**
     * Table related to this migration.
     *
     * @var string
     */
    private $table = 'tracker_sessions';

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
                $table->bigInteger('language_id')->unsigned()->nullable()->index();
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
//                $table->dropColumn('language_id');
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
            $table->dropIndex('tracker_sessions_language_id_index');
            $table->dropColumn('language_id');
        });
    }
}
