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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constraint('users')->cascadeOnDelete();
            $table->foreignId('office_id')->nullable()->constraint('offices')->nullOnDelete();
            $table->string('photo');
            $table->integer('size')->unsigned();
            $table->string('location');
            $table->integer('price')->unsigned();
            $table->string('status')->default('pending');
            $table->string('property')->nullable();
            $table->string('renting_period')->nullable();
            $table->enum('type',['renting','selling']);
            $table->string('contact_information');
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
        Schema::dropIfExists('shops');
    }
};
