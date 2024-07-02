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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('name', 512)->unique();
            $table->foreignId('image_id')->constrained();
            $table->string('link', 1024);
            $table->integer('clicks_limit');
            $table->integer('clicks_count')->default(0);
            $table->enum('type', ['top', 'block', 'popup',]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
