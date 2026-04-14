<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_price_options', function (Blueprint $table) {
            $table->dropForeign(['product_price_id']);
            $table->dropColumn('product_price_id');
        });

        Schema::dropIfExists('product_prices');
    }

    public function down(): void
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('title');
            $table->unsignedInteger('price')->default(0);
            $table->timestamps();
        });

        Schema::table('product_price_options', function (Blueprint $table) {
            $table->foreignId('product_price_id')->constrained('product_prices')->cascadeOnDelete();
        });
    }
};
