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
        Schema::table('sales', function (Blueprint $table) {
            // Add soft delete timestamp only if it doesn't exist
            if (!Schema::hasColumn('sales', 'deleted_at')) {
                $table->softDeletes();
            }

            // Track who last edited this sale
            if (!Schema::hasColumn('sales', 'last_edited_by')) {
                $table->foreignId('last_edited_by')
                      ->nullable()
                      ->constrained('users')
                      ->nullOnDelete();
            }

            // Track when the sale was last edited
            if (!Schema::hasColumn('sales', 'last_edited_at')) {
                $table->timestamp('last_edited_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropForeign(['last_edited_by']);
            $table->dropColumn(['last_edited_by', 'last_edited_at']);
        });
    }
};
