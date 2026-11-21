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
        Schema::create('game_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')
                ->constrained(
                    table: 'games',
                    column: 'game_id',
                    indexName: 'game_tag_game_id'
                )->cascadeOnDelete();
            $table->foreignId('tag_id')
                ->constrained(
                    table: 'tags',
                    column: 'tag_id',
                    indexName: 'game_tag_tag_id'
                )->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_tag');
    }
};
