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
        Schema::create('passimpay_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->integer('payment_id');
            $table->string('address_to');
            $table->string('amount');
            $table->string('transaction_id');
            $table->string('txhash')->nullable();
            $table->integer('confirmations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passimpay_withdrawals');
    }
};
