<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menambahkan kolom auth_bg jika tabel settings kamu sudah ada
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'auth_bg')) {
                    $table->string('auth_bg')->nullable()->after('id');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('settings') && Schema::hasColumn('settings', 'auth_bg')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('auth_bg');
            });
        }
    }
};
