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
        Schema::create('game_os', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')
                ->constrained(
                    table: 'games',
                    column: 'game_id',
                    indexName: 'game_os_game_id'
                )->cascadeOnDelete();
            $table->foreignId('os_id')
                ->constrained(
                    table: 'operating_systems',
                    column: 'os_id',
                    indexName: 'game_tag_os_id'
                )->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_os');
    }
};
