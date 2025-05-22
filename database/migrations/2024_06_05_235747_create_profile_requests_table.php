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
        Schema::create('profile_requests', function (Blueprint $table) {
            $table->id();

            $table->json('name')->nullable();
            $table->json('age')->nullable();
            $table->json('gender')->nullable();
            $table->json('description')->nullable();

            $table->json('phone')->nullable();
            $table->json('profile_email')->nullable();
            $table->json('instagram')->nullable();
            $table->json('telegram')->nullable();
            $table->json('snapchat')->nullable();
            $table->json('onlyfans')->nullable();
            $table->json('whatsapp')->nullable();
            $table->json('twitter')->nullable();
            
            $table->json('location')->nullable();
            
            $table->json('first_name')->nullable();
            $table->json('last_name')->nullable();
            $table->json('birthday')->nullable();
            $table->json('verification_photo')->nullable();
            $table->json('id_photo')->nullable();
            $table->json('street_photo')->nullable();

            $table->json('photos')->nullable();
            
            $table->enum('status', ['done', 'undone',])->default('undone');

            $table->foreignId('creator_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_requests');
    }
};
