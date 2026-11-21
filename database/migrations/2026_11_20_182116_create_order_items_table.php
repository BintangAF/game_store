<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained(
                    table: 'orders',
                    column: 'order_id',
                    indexName: 'order_items_order_id'
                )->cascadeOnDelete();
            $table->foreignId('game_id')
                ->constrained(
                    table: 'games',
                    column: 'game_id',
                    indexName: 'order_items_game_id'
                )->cascadeOnDelete();
            $table->decimal('price_at_purchase', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
