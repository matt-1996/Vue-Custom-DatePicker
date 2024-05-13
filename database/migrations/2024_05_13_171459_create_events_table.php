<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->string('check_in')->nullable();
            $table->string('check_out')->nullable();
            $table->string('date');
            $table->boolean('is_open');
            $table->boolean('has_discount')->default(0);
            $table->boolean('is_reserved');
            $table->integer('price');
            $table->index(['date', 'price' , 'room_id' ]);
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};