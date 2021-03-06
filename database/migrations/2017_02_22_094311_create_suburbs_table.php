<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuburbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('suburbs')) {
            Schema::create('suburbs', function (Blueprint $table) {
                $table->increments('suburb_id');
                $table->string('id', 5);
                $table->string('name', 100)->nullable();
                $table->integer('availability')->nullable();
                $table->decimal('latitude', 6, 3);
                $table->decimal('longitude', 6, 3);
                $table->integer('max_tradie');
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
        Schema::dropIfExists('suburbs');
    }
}
