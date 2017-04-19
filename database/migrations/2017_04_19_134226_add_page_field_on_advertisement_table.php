<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPageFieldOnAdvertisementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('advertisements')) {
            Schema::table('advertisements', function (Blueprint $table) {
                $table
                    ->string('page')
                    ->default('home')
                    ->comment = 'Page to display ads banner either "home" or "tradies" page';
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
        Schema::table('advertisements', function($table) {
            $table->dropColumn('page');
        });
    }
}
