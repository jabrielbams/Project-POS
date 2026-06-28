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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('auditable_type');              // e.g., "App\Models\Sale"
            $table->unsignedBigInteger('auditable_id');   // ID of the model being audited
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');                  // Who made the change
            $table->string('action');                      // "edit", "delete", "restore"
            $table->json('old_values')->nullable();       // Previous values
            $table->json('new_values')->nullable();       // New values
            $table->json('changed_fields')->nullable();   // Array of field names
            $table->text('reason')->nullable();           // Optional reason
            $table->timestamps();

            // Indexes for performance
            $table->index(['auditable_type', 'auditable_id']);
            $table->index('user_id');
            $table->index('created_at');
            $table->index('action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
