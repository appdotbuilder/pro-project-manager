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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name')->comment('Project name');
            $table->string('code')->unique()->comment('Project code/identifier');
            $table->text('description')->nullable()->comment('Project description');
            $table->string('location')->nullable()->comment('Project location');
            $table->date('start_date')->nullable()->comment('Project start date');
            $table->date('end_date')->nullable()->comment('Project end date');
            $table->decimal('budget', 15, 2)->nullable()->comment('Project budget');
            $table->enum('status', ['planning', 'active', 'on_hold', 'completed', 'cancelled'])->default('planning')->comment('Project status');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index('code');
            $table->index('company_id');
            $table->index('status');
            $table->index(['status', 'start_date']);
            $table->index(['company_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};