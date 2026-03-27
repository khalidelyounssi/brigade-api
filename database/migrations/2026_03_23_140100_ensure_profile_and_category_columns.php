<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && ! Schema::hasColumn('users', 'dietary_tags')) {
            Schema::table('users', function (Blueprint $table) {
                $table->json('dietary_tags')->nullable()->after('role');
            });
        }

        if (Schema::hasTable('categories') && ! Schema::hasColumn('categories', 'user_id')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('is_active')->constrained()->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        // Intentionally left empty to avoid destructive rollback on shared columns.
    }
};
