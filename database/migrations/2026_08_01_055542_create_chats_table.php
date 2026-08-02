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
    Schema::create('chats', function (Blueprint $table) {
        $table->id();
        $table->string('sender_name'); // Nama pengunjung
        $table->string('sender_email'); // Email pengunjung
        $table->text('message'); // Isi pesan
        $table->enum('sender_type', ['user', 'admin']); // Siapa yang mengirim (pengunjung atau admin)
        $table->boolean('is_read')->default(false); // Status dibaca/belum
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
