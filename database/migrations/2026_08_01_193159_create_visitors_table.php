<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('visitors', function (Blueprint $table) {
        $table->id();
        $table->string('ip_address');
        $table->text('user_agent')->nullable();
        $table->date('visit_date');
        $table->timestamps();

        // HAPUS baris $table->unique(...) agar tidak terjadi error constraint saat beda browser
    });
}

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
