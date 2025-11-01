<?php
// database/migrations/2024_01_01_000001_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('nik', 16)->unique()->nullable();
            $table->enum('role', ['masyarakat', 'petugas'])->default('masyarakat');
            $table->rememberToken();
            $table->timestamps();
            
            $table->index('role');
            $table->index('email');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};