<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_contents', function (Blueprint $table): void {
            $table->id();
            $table->string('locale', 8);
            $table->string('section', 50);
            $table->string('label', 150)->nullable();
            $table->string('key', 150);
            $table->text('value');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['locale', 'key']);
            $table->index(['locale', 'section']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_contents');
    }
};
