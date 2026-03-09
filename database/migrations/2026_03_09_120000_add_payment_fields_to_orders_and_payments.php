<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('currency', 3)->default('KZT')->after('amount');
            $table->string('payment_method', 64)->default('manager_confirmation')->after('status');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('store_amount', 10, 2)->unsigned()->default(0)->after('currency');
            $table->string('store_currency', 3)->default('KZT')->after('store_amount');
            $table->decimal('conversion_rate', 12, 6)->unsigned()->default(1)->after('store_currency');
            $table->string('checkout_flow', 64)->default('redirect')->after('conversion_rate');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'store_amount',
                'store_currency',
                'conversion_rate',
                'checkout_flow',
            ]);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'currency',
                'payment_method',
            ]);
        });
    }
};
