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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constraint('users')->cascadeOnDelete();
            $table->foreignId('office_id')->nullable()->constraint('offices')->nullOnDelete();
            $table->string('photo');
            $table->integer('size')->unsigned();
            $table->string('location');
            $table->integer('price')->unsigned();
            $table->string('view');
            $table->string('room_number');
            $table->string('bathrooms');
            $table->string('cladding');
            $table->string('floor');
            $table->string('property')->nullable();
            $table->string('renting_period')->nullable();
            $table->enum('type',['renting','selling']);
            $table->float('rating')->default(0);
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
        Schema::dropIfExists('apartments');
    }
};
