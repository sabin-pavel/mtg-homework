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
        Schema::create('cards', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('name');
            $table->integer('multiverseId')->nullable();
            $table->string('layout');
            $table->string('manaCost')->nullable();
            $table->integer('cmc')->default(0);
            $table->json('colors')->nullable();
            $table->json('colorIdentity')->nullable();
            $table->json('names')->nullable();
            $table->string('type');
            $table->json('supertypes')->nullable();
            $table->json('types')->nullable();
            $table->json('subtypes')->nullable();
            $table->string('rarity');
            $table->text('text')->nullable();
            $table->text('flavor')->nullable();
            $table->string('artist')->nullable();
            $table->string('number')->nullable();
            $table->string('power')->nullable();
            $table->string('toughness')->nullable();
            $table->string('loyalty')->nullable();
            $table->json('variations')->nullable();
            $table->string('watermark')->nullable();
            $table->string('border')->nullable();
            $table->boolean('isTimeShifted')->default(false);
            $table->string('hand')->nullable();
            $table->string('life')->nullable();
            $table->boolean('isReserved')->default(false);
            $table->date('releaseDate')->nullable();
            $table->boolean('isStarter')->default(false);
            $table->json('rulings')->nullable();
            $table->json('foreignNames')->nullable();
            $table->json('printings')->nullable();
            $table->text('originalText')->nullable();
            $table->string('originalType')->nullable();
            $table->json('legalities')->nullable();
            $table->string('source')->nullable();
            $table->text('imageUrl')->nullable();
            $table->string('set')->nullable();
            $table->string('setName')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
