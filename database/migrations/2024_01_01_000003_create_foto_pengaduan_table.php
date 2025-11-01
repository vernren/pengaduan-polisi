<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('foto_pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduan')->onDelete('cascade');
            $table->string('file_path');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->index('pengaduan_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('foto_pengaduan');
    }
};
