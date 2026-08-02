<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('settings', function (Blueprint $table) {
        if (!Schema::hasColumn('settings', 'site_name')) {
            $table->string('site_name')->nullable();
        }
        if (!Schema::hasColumn('settings', 'site_title')) {
            $table->string('site_title')->nullable();
        }
        if (!Schema::hasColumn('settings', 'meta_description')) {
            $table->text('meta_description')->nullable();
        }
        if (!Schema::hasColumn('settings', 'meta_keywords')) {
            $table->text('meta_keywords')->nullable();
        }
    });
}

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['site_title', 'meta_description', 'meta_keywords']);
        });
    }
};
