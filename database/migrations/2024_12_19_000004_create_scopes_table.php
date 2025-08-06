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
        Schema::create('scopes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Scope name (Structural, Architectural, MEP, etc.)');
            $table->string('code')->unique()->comment('Scope code identifier');
            $table->text('description')->nullable()->comment('Scope description');
            $table->string('color')->default('#3B82F6')->comment('Scope color for UI');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scopes');
    }
};