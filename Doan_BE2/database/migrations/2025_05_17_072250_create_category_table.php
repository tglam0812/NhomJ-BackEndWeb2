<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_name', 100);
            $table->text('category_description')->nullable(); 
            $table->boolean('category_status')->default(1); 
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
