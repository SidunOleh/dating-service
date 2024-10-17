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
        Schema::create('passimpay_deposits', function (Blueprint $table) {
            $table->id();
            $table->integer('payment_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('txhash')->nullable();
            $table->string('address_from')->nullable();
            $table->string('address_to')->nullable();
            $table->integer('confirmations')->nullable();
            $table->integer('destination_tag')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passimpay_deposits');
    }
};
