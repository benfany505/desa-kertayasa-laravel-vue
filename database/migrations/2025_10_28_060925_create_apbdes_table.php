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
        Schema::create('apbdes', function (Blueprint $table) {
            $table->id();
            $table->year('year')->unique();
            $table->text('revenue_details')->nullable();
            $table->bigInteger('total_revenue')->default(0);
            $table->text('expenditure_details')->nullable();
            $table->bigInteger('total_expenditure')->default(0);
            $table->bigInteger('balance')->default(0);
            $table->bigInteger('total_spending')->default(0);
            $table->bigInteger('total_income')->default(0);
            $table->bigInteger('total_financing')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apbdes');
    }
};
