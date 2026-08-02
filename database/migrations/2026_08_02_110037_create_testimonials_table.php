<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_title'); // Contoh: CEO at TechCorp / Freelancer
            $table->text('quote');
            $table->string('avatar')->nullable(); // Foto klien (opsional)
            $table->unsignedTinyInteger('rating')->default(5); // Rating 1-5 bintang
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
