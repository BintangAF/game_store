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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('review_id');
            $table->tinyInteger('star');
            $table->text('body')->nullable();
            $table->foreignId('user_id')
                ->constrained(
                    table: 'users',
                    column: 'user_id',
                    indexName: 'reviews_user_id'
                )->cascadeOnDelete();
            $table->foreignId('game_id')
                ->constrained(
                    table: 'games',
                    column: 'game_id',
                    indexName: 'reviews_game_id'
                )->cascadeOnDelete();
            $table->timestamps();

            // 1 user hanya bisa review 1 kali di satu game
            $table->unique(['user_id', 'game_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
