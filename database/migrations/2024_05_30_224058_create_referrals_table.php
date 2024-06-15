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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referrer_id');
            $table->foreign('referrer_id')
                ->references('id')
                ->on('creators')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('referee_id');
            $table->foreign('referee_id')
                ->references('id')
                ->on('creators')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->decimal('reward', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
