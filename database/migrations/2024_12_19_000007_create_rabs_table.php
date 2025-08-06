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
        Schema::create('rabs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('scope_id')->constrained()->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->string('title')->comment('RAB title/name');
            $table->text('description')->nullable()->comment('RAB description');
            $table->string('file_path')->comment('Path to uploaded RAB file');
            $table->string('file_name')->comment('Original file name');
            $table->string('file_type')->comment('File MIME type');
            $table->bigInteger('file_size')->comment('File size in bytes');
            $table->decimal('total_amount', 15, 2)->nullable()->comment('Total RAB amount');
            $table->string('version', 10)->default('1.0')->comment('RAB version');
            $table->enum('status', ['draft', 'review', 'approved', 'rejected'])->default('draft')->comment('RAB status');
            $table->text('notes')->nullable()->comment('Additional notes or comments');
            $table->timestamp('approved_at')->nullable()->comment('When RAB was approved');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('project_id');
            $table->index('scope_id');
            $table->index('uploaded_by');
            $table->index('status');
            $table->index(['project_id', 'scope_id']);
            $table->index(['project_id', 'status']);
            $table->index(['scope_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rabs');
    }
};