<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->enum('status', ['booked', 'attended', 'cancelled', 'no_show'])->default('booked');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['member_id', 'class_id']); // prevent duplicate bookings
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_bookings');
    }
};
