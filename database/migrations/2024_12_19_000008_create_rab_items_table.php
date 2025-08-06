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
        Schema::create('rab_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rab_id')->constrained()->onDelete('cascade');
            $table->string('item_code')->comment('Item code/number');
            $table->string('description')->comment('Item description');
            $table->string('unit')->comment('Unit of measurement');
            $table->decimal('quantity', 12, 3)->comment('Quantity');
            $table->decimal('unit_price', 12, 2)->comment('Unit price');
            $table->decimal('total_price', 15, 2)->comment('Total price (quantity * unit_price)');
            $table->text('notes')->nullable()->comment('Additional notes for this item');
            $table->integer('sort_order')->default(0)->comment('Sort order for display');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('rab_id');
            $table->index('item_code');
            $table->index(['rab_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rab_items');
    }
};