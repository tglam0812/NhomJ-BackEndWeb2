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
        Schema::create('phieu_giam_gia', function (Blueprint $table) {
            $table->id(); // Khóa chính auto_increment
            $table->string('ten_phieu');
            $table->integer('phan_tram_giam');
            $table->integer('so_luong');
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');
            $table->text('mo_ta')->nullable();
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phieu_giam_gia');
    }
};
