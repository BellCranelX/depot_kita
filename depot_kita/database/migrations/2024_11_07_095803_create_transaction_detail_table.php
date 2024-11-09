<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('transaction_detail', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('transaction_detail_id')->constrained('transaction');
    //         $table->foreignId('product_id')->constrained('product');
    //         $table->integer('quantity');
    //         $table->decimal('price', 8, 2);
    //         $table->decimal('subtotal', 8, 2);
    //         $table->timestamps();
    //     });
    // }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_detail');
    }
};