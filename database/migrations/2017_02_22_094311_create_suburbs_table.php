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
                $table->increments('id');
                $table->string('name', 100)->nullable();
                $table->integer('availability', 10);
                $table->decimal('latitude', 6, 3);
                $table->decimal('longitude', 6, 3);
                $table->integer('max_tradie', 10);
                $table->timestamps('updated_at');
                $table->timestamp('created_at');
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
