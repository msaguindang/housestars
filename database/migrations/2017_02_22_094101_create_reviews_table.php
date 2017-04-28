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
        if (!Schema::hasTable('reviews')) {
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
                $table->string('title', 1000)->nullable();
                $table->string('content', 2000)->nullable();
                $table->integer('helpful')->nullable();
                $table->integer('transaction', 11)->nullable();
                $table->string('user_type')->default('potential_customer');
                $table->timestamp();
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
        Schema::dropIfExists('reviews');
    }
}
