<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('full_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->date('date')->nullable();
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->unsignedInteger('level_id');
            $table->string('status')->default('Active');
            $table->string('about')->nullable();
            $table->rememberToken(); // remember_token
            $table->timestamps();

            $table->foreign('level_id')->references('level_id')->on('level_user')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
