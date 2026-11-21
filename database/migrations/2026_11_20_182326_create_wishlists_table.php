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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id('wishlist_id');
            $table->foreignId('user_id')
                ->constrained(
                    table: 'users',
                    column: 'user_id',
                    indexName: 'wishlists_user_id'
                )->cascadeOnDelete();
            $table->foreignId('game_id')
                ->constrained(
                    table: 'games',
                    column: 'game_id',
                    indexName: 'wishlists_game_id'
                )->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'game_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
