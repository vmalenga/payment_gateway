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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 32);
            $table->decimal('amount', 12, 3);
            $table->string('currency', 8)->nullable();
            $table->tinyInteger('amountType')->default(0)->comment('0 fixed, -1 flexible, 1 full');
            $table->string('paymentType', 16)->nullable()->comment('credited account code');
            $table->foreignId('payer_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('currency_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
