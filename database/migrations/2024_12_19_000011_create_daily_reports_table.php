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
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('generated_by')->constrained('users')->onDelete('cascade');
            $table->date('report_date')->comment('Date of the report');
            $table->string('report_number')->unique()->comment('Unique report number');
            $table->json('personnel_presence')->nullable()->comment('Contractor/MK personnel presence as JSON');
            $table->enum('weather', ['sunny', 'cloudy', 'rainy', 'stormy'])->nullable()->comment('Weather conditions');
            $table->text('safety_notes')->nullable()->comment('K3/Safety notes');
            $table->text('general_notes')->nullable()->comment('General notes for the day');
            $table->json('activities_summary')->nullable()->comment('Summary of activities as JSON');
            $table->json('materials_summary')->nullable()->comment('Summary of materials used as JSON');
            $table->json('manpower_summary')->nullable()->comment('Summary of manpower as JSON');
            $table->decimal('overall_progress', 5, 2)->nullable()->comment('Overall progress percentage');
            $table->enum('status', ['draft', 'finalized', 'sent'])->default('draft')->comment('Report status');
            $table->timestamp('finalized_at')->nullable()->comment('When report was finalized');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('project_id');
            $table->index('generated_by');
            $table->index('report_date');
            $table->index('report_number');
            $table->index('status');
            $table->index(['project_id', 'report_date']);
            $table->index(['project_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};