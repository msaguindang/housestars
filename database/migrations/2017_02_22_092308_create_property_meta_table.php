<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('property_meta')) {
            Schema::create('property_meta', function (Blueprint $table) {
                $table->increments('id', 11);
                $table->integer('user_id');
                $table->string('meta_name', 50);
                $table->string('meta_value', 1000);
                $table->string('property_code', 50);
                $table->timestamps();
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
        Schema::dropIfExists('property_meta');
    }
}
