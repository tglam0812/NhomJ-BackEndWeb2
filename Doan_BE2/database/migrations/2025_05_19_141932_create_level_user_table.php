<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('level_user', function (Blueprint $table) {
            $table->id('level_id');
            $table->string('level_name');
            $table->timestamps(); // Tạo cột created_at và updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('level_user');
    }
};
