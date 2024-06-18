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
        Schema::create('creators', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');

            $table->boolean('is_banned')->default(false);
            $table->boolean('show_on_site')->default(true);
            $table->boolean('play_roulette')->default(true);
            $table->boolean('created_by_admin')->default(false);

            $table->boolean('is_approved')->default(false);

            $table->json('photos')->nullable();

            $table->string('name')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->text('description')->nullable();

            $table->string('phone')->nullable();
            $table->string('profile_email')->nullable();
            $table->string('instagram')->nullable();
            $table->string('telegram')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('onlyfans')->nullable();
            $table->string('whatsapp')->nullable();
            
            $table->string('full_address')->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();     
            $table->index('latitude');       

            $table->boolean('is_verified')->default(false);
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birthday')->nullable();
            $table->foreignId('id_photo')
                ->nullable()
                ->constrained('images')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('street_photo')
                ->nullable()
                ->constrained('images')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->unsignedInteger('referral_code');
            $table->decimal('balance', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creators');
    }
};
