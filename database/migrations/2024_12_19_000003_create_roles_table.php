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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Role name (Owner, MK, Contractor, Planner, QS)');
            $table->string('slug')->unique()->comment('Role slug identifier');
            $table->text('description')->nullable()->comment('Role description');
            $table->json('permissions')->nullable()->comment('Role permissions as JSON');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};