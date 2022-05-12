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
        Schema::create('denemeler', function (Blueprint $table) {
          $table->id();
          $table->string('deneme_name');
          $table->string('deneme_type');
          $table->string('uygulama_tarihi')->nullable();
          $table->integer('kac_yanlis_bir_dogru')->default(3);
          $table->unsignedBigInteger('user_id');
          $table->unsignedBigInteger('dublicated');
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->unsignedBigInteger('period_id');
          $table->foreign('period_id')->references('id')->on('periods')->onDelete('cascade');
          $table->boolean('is_answer')->default(0);
          $table->boolean('is_primary')->default(1);
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
        Schema::dropIfExists('denemeler');
    }
};
