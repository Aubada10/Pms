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
        Schema::create('shop_drafts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constraint('users')->cascadeOnDelete();
            $table->foreignId('office_id')->constraint('offices')->cascadeOnDelete();
            $table->string('photo')->nullable();
            $table->integer('size')->unsigned()->nullable();
            $table->string('location')->nullable();
            $table->integer('price')->unsigned()->nullable();
            $table->string('property')->nullable();
            $table->string('renting_period')->nullable();
            $table->enum('type',['renting','selling'])->nullable();
            $table->string('contact_information')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_drafts');
    }
};
