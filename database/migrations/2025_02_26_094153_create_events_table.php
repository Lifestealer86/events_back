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
            $table->string('name');
            $table->integer('event_counter');
            $table->integer('current_people')->default(0);
            $table->string('description');
            $table->string('img');
            $table->integer('raiting')->default(0);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->foreignId('event_place_id')->constrained('event_places')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
