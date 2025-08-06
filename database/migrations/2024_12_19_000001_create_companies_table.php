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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Company name');
            $table->string('code')->unique()->comment('Company code/identifier');
            $table->text('description')->nullable()->comment('Company description');
            $table->string('address')->nullable()->comment('Company address');
            $table->string('phone')->nullable()->comment('Company phone number');
            $table->string('email')->nullable()->comment('Company email');
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Company status');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index('code');
            $table->index('status');
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};