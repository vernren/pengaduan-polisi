<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('lokasi')->nullable();
            $table->date('tanggal_kejadian')->nullable();
            $table->enum('kategori', ['pencurian', 'kekerasan', 'narkoba', 'lalu_lintas', 'lainnya']);
            $table->enum('status', ['pending', 'diproses', 'selesai', 'ditolak'])->default('pending');
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->text('tanggapan')->nullable();
            $table->foreignId('petugas_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index('status');
            $table->index('user_id');
            $table->index('petugas_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaduan');
    }
};
