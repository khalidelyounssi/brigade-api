<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ingredients') && ! Schema::hasColumn('ingredients', 'tags')) {
            Schema::table('ingredients', function (Blueprint $table) {
                $table->json('tags')->nullable()->after('name');
            });
        }

        if (Schema::hasTable('recommendations')) {
            Schema::table('recommendations', function (Blueprint $table) {
                if (! Schema::hasColumn('recommendations', 'status')) {
                    $table->string('status')->default('processing')->after('warning_message');
                }
            });

            try {
                Schema::table('recommendations', function (Blueprint $table) {
                    $table->unique(['user_id', 'plate_id'], 'recommendations_user_plate_unique');
                });
            } catch (Throwable $exception) {
                // Keep migration idempotent for databases where the index already exists.
            }
        }
    }

    public function down(): void
    {
        // Intentionally left empty to avoid destructive rollback on shared columns.
    }
};
