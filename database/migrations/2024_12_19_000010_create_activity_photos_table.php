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
        Schema::create('activity_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_activity_id')->constrained()->onDelete('cascade');
            $table->string('file_path')->comment('Path to photo file');
            $table->string('file_name')->comment('Original file name');
            $table->string('file_type')->comment('File MIME type');
            $table->bigInteger('file_size')->comment('File size in bytes');
            $table->text('caption')->nullable()->comment('Photo caption/description');
            $table->json('metadata')->nullable()->comment('Photo metadata (GPS, timestamp, etc.)');
            $table->integer('sort_order')->default(0)->comment('Sort order for display');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('daily_activity_id');
            $table->index(['daily_activity_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_photos');
    }
};