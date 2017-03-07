<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('reviewee_id')->nullable();
            $table->string('reviewer_id');
            $table->string('name');
            $table->integer('communication')->nullable();
            $table->integer('work_quality')->nullable();
            $table->integer('price')->nullable();
            $table->integer('punctuality')->nullable();
            $table->integer('attitude')->nullable();
            $table->string('title')->nullable();
            $table->string('content', 2000)->nullable();
            $table->integer('helpful')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
