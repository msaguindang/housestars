<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColumnToPropertyMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('property_meta', 'status')) {
            Schema::table('property_meta', function ($table) {
                $table->integer('status')->default(true);
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
        if (Schema::hasColumn('property_meta', 'status')) {
            Schema::table('property_meta', function ($table) {
                $table->dropColumn('status');
            });
        }

    }
}
