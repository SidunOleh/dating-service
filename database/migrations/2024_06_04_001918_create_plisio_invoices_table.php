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
        Schema::create('plisio_invoices', function (Blueprint $table) {
            $table->id();
            
            $table->string('txn_id');
            $table->string('invoice_url');
            
            $table->decimal('amount', 16, 8)->nullable();
            $table->string('currency')->nullable();
            $table->unsignedBigInteger('order_number')->nullable();
            $table->string('order_name')->nullable();
            $table->string('status')->default('new');
            $table->string('wallet_hash')->nullable();
            $table->decimal('source_amount', 16, 8)->nullable();
            $table->string('source_currency')->nullable();
            $table->decimal('source_rate', 16, 8)->nullable();
            $table->decimal('invoice_sum', 16, 8)->nullable();
            $table->decimal('invoice_commission', 16, 8)->nullable();
            $table->decimal('invoice_total_sum', 16, 8)->nullable();
            $table->text('qr_code')->nullable();
            $table->integer('expire_at_utc')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plisio_invoices');
    }
};
