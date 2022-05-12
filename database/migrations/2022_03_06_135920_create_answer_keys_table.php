<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_keys', function (Blueprint $table) {
          $table->id();
          $table->text('answer_key'); // a: {'c', 'b', 'd'} , b: {'d', 'a', 'c'}
          $table->unsignedBigInteger('deneme_id');
          $table->foreign('deneme_id')->references('id')->on('denemeler')->onDelete('cascade');
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
        Schema::dropIfExists('answer_keys');
    }
};