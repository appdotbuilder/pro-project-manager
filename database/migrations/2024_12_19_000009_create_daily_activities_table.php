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
        Schema::create('daily_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('scope_id')->nullable()->constrained()->onDelete('set null');
            $table->date('activity_date')->comment('Date of the activity');
            $table->string('activity_type')->comment('Type of activity');
            $table->text('description')->comment('Activity description');
            $table->json('manpower')->nullable()->comment('Manpower details as JSON');
            $table->json('materials')->nullable()->comment('Materials used as JSON');
            $table->decimal('work_progress_weight', 5, 2)->nullable()->comment('Work progress weight percentage');
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->enum('weather', ['sunny', 'cloudy', 'rainy', 'stormy'])->nullable()->comment('Weather conditions');
            $table->text('safety_notes')->nullable()->comment('K3/Safety notes');
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft')->comment('Activity status');
            $table->timestamp('submitted_at')->nullable()->comment('When activity was submitted');
            $table->timestamp('approved_at')->nullable()->comment('When activity was approved');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('project_id');
            $table->index('user_id');
            $table->index('scope_id');
            $table->index('activity_date');
            $table->index('status');
            $table->index(['project_id', 'activity_date']);
            $table->index(['project_id', 'status']);
            $table->index(['user_id', 'activity_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_activities');
    }
};