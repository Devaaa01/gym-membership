<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained('trainers')->onDelete('restrict');
            $table->string('name');                     // e.g. Morning Yoga, HIIT Blast
            $table->text('description')->nullable();
            $table->string('category');                 // e.g. Yoga, Cardio, Strength
            $table->dateTime('schedule');               // date & time of class
            $table->integer('duration_minutes')->default(60);
            $table->integer('max_capacity')->default(20);
            $table->string('room')->nullable();
            $table->enum('status', ['scheduled', 'cancelled', 'completed'])->default('scheduled');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
