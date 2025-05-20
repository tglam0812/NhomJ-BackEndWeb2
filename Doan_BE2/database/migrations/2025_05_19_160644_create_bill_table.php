<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bill', function (Blueprint $table) {
            $table->id('bill_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('total_qty')->default(0);
            $table->bigInteger('total_amount')->default(0);
            $table->dateTime('date_invoice')->nullable();
            $table->string('status')->default('pending');
            $table->string('note')->nullable();
            $table->unsignedBigInteger('phieu_giam_id')->nullable();
            $table->timestamps();

            // Ràng buộc khóa ngoại
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('phieu_giam_id')->references('id')->on('phieu_giam_gia')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill');
    }
};
