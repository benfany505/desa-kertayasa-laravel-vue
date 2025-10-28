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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->longText('requirements'); // Persyaratan layanan
            $table->longText('process_flow'); // Alur proses
            $table->string('icon')->nullable(); // Icon class atau file
            $table->integer('processing_days')->default(1); // Estimasi hari
            $table->decimal('fee', 10, 2)->default(0); // Biaya layanan
            $table->boolean('is_online')->default(false); // Bisa online atau tidak
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('required_documents')->nullable(); // List dokumen yang diperlukan
            $table->timestamps();

            $table->index(['is_active', 'is_online']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
