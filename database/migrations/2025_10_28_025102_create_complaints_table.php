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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique(); // Auto-generated
            $table->string('complainant_name');
            $table->string('complainant_email')->nullable();
            $table->string('complainant_phone')->nullable();
            $table->text('complainant_address')->nullable();
            $table->string('subject');
            $table->longText('description');
            $table->enum('category', ['infrastruktur', 'pelayanan', 'kebersihan', 'keamanan', 'lainnya']);
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['submitted', 'under_review', 'in_progress', 'resolved', 'closed'])->default('submitted');
            $table->json('attachments')->nullable(); // File attachments
            $table->text('admin_notes')->nullable();
            $table->text('resolution')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['status', 'priority']);
            $table->index('ticket_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
