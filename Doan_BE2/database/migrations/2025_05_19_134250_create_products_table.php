<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('product_id');
            $table->string('product_name', 255);
            $table->double('product_price');
            $table->integer('product_qty');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('brand_id');
            $table->string('product_description', 10000);
            $table->string('product_status', 255);
            $table->string('product_images_1', 255)->nullable();
            $table->string('product_images_2', 255)->nullable();
            $table->string('product_images_3', 255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            // Nếu bạn có bảng categories và brands, có thể thêm ràng buộc khóa ngoại:
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            // $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
