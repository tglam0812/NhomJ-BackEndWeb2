<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('billdetail', function (Blueprint $table) {
            $table->id('bill_detail_id');
            $table->unsignedBigInteger('bill_id');
            $table->unsignedBigInteger('cart_id')->nullable(); 
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->default(1);
            $table->bigInteger('price')->default(0);
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('bill_id')->references('bill_id')->on('bill')->onDelete('cascade');
            $table->foreign('cart_id')->references('cart_id')->on('cart')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billdetail');
    }
};
