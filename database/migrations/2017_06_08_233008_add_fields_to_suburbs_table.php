<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToSuburbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('suburbs')) {
            Schema::table('suburbs', function (Blueprint $table) {
                $table->integer('manual_availability')->default(0);
                $table->integer('total_availability')->default(0);
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
        Schema::table('suburbs', function($table) {
            $table->dropColumn('manual_availability');
            $table->dropColumn('total_availability');
        });
    }
}
