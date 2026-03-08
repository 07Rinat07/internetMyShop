<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $duplicates = DB::table('basket_product')
            ->select(
                'basket_id',
                'product_id',
                DB::raw('MIN(id) as keep_id'),
                DB::raw('SUM(quantity) as total_quantity')
            )
            ->groupBy('basket_id', 'product_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('basket_product')
                ->where('id', $duplicate->keep_id)
                ->update(['quantity' => (int) $duplicate->total_quantity]);

            DB::table('basket_product')
                ->where('basket_id', $duplicate->basket_id)
                ->where('product_id', $duplicate->product_id)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
        }

        Schema::table('basket_product', function (Blueprint $table) {
            $table->unique(['basket_id', 'product_id'], 'basket_product_basket_id_product_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basket_product', function (Blueprint $table) {
            $table->dropUnique('basket_product_basket_id_product_id_unique');
        });
    }
};
