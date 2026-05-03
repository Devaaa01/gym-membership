<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');                     // e.g. Basic, Silver, Gold, Platinum
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);            // monthly price
            $table->integer('duration_months');         // plan duration in months
            $table->integer('max_classes')->default(0); // 0 = unlimited
            $table->boolean('personal_trainer')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_plans');
    }
};
