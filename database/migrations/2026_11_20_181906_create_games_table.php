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
        Schema::create('games', function (Blueprint $table) {
            $table->id('game_id');
            $table->string('game_title', 100);
            $table->decimal('game_price', 10, 2);
            $table->text('game_desc');
            $table->string('cover_image_path', 255)->nullable();
            $table->string('game_file_path', 255)->nullable();
            $table->date('release_date');
            $table->text('system_requirements')->nullable();
            $table->string('developer_name', 50)->nullable();
            $table->string('publisher_name', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
