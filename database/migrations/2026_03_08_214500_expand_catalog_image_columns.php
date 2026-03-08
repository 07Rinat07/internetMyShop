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
        Schema::table('brands', function (Blueprint $table) {
            $table->string('image', 255)->nullable()->change();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('image', 255)->nullable()->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('image', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('image', 50)->nullable()->change();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('image', 50)->nullable()->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('image', 50)->nullable()->change();
        });
    }
};
