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
        Schema::create('decks_cards', function (Blueprint $table) {
            $table->uuid('deck_id');
            $table->uuid('card_uuid');
            $table->timestamps();

            $table->unique(['deck_id', 'card_uuid']);

            $table->foreign('card_uuid')
                ->references('uuid')
                ->on('cards')
                ->onDelete('cascade');

            $table->foreign('deck_id')
                ->references('id')
                ->on('decks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decks_cards');
    }
};
