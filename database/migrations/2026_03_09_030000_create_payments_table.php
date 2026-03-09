<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('provider', 64);
            $table->string('status', 64);
            $table->decimal('amount', 10, 2)->unsigned();
            $table->string('currency', 3);
            $table->string('provider_payment_id')->nullable()->index();
            $table->string('provider_operation_id')->nullable();
            $table->text('redirect_url')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('last_webhook_at')->nullable();
            $table->string('failure_reason')->nullable();
            $table->json('raw_create_payload')->nullable();
            $table->json('raw_create_response')->nullable();
            $table->json('raw_webhook_payload')->nullable();
            $table->timestamps();

            $table->index(['provider', 'provider_payment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
