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
        Schema::create('project_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('scope_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('User status in project');
            $table->timestamp('assigned_at')->useCurrent()->comment('When user was assigned to project');
            $table->timestamps();
            
            // Unique constraint - user can only have one role per project per scope
            $table->unique(['project_id', 'user_id', 'role_id', 'scope_id']);
            
            // Indexes for performance
            $table->index('project_id');
            $table->index('user_id');
            $table->index('role_id');
            $table->index('scope_id');
            $table->index('status');
            $table->index(['project_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_users');
    }
};