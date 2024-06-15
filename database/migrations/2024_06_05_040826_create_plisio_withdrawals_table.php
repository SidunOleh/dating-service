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
        Schema::create('plisio_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 16, 8);
            $table->string('currency');
            $table->enum('type', ['cash_out', 'mass_cash_out',]);
            $table->string('status');
            $table->string('source_currency');
            $table->decimal('source_rate', 16, 8);
            $table->decimal('fee', 16, 8);
            $table->string('plisio_id');
            $table->string('wallet_hash')->nullable();
            $table->json('sendmany')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plisio_withdrawals');
    }
};
