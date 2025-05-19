<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brand', function (Blueprint $table) {
            $table->id('brand_id');
            $table->string('brand_name');
            $table->string('brand_description')->nullable();
            $table->string('brand_status')->default('Active');
            $table->timestamps(); // created_at + updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brand');
    }
};
