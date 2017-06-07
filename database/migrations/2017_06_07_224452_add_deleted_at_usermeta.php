<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeletedAtUsermeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('user_meta', 'deleted_at')) {
            Schema::table('user_meta', function ($table) {
                $table->softDeletes();
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
        if (Schema::hasColumn('user_meta', 'deleted_at')) {
            Schema::table('user_meta', function ($table) {
                $table->dropColumn('deleted_at');
            });
        }
    }
}
