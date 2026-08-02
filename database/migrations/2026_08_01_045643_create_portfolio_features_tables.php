<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Projects
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        // Tabel Blogs
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });

        // Tabel Pricelists
        Schema::create('pricelists', function (Blueprint $table) {
            $table->id();
            $table->string('package_name');
            $table->decimal('price', 15, 2);
            $table->json('features'); // Menyimpan daftar fitur dalam format JSON
            $table->timestamps();
        });

        // Tabel Testimoni
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->text('message');
            $table->string('avatar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('pricelists');
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('projects');
    }
};
