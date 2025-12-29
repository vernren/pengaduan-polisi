<?php
// database/migrations/2024_01_15_000001_update_pengaduan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            // Hapus kolom prioritas
            $table->dropColumn('prioritas');
            
            // Ubah kolom kategori menjadi text untuk menampung kategori utama
            $table->string('kategori_utama', 50)->after('tanggal_kejadian');
            
            // Tambah kolom sub_kategori
            $table->string('sub_kategori', 100)->after('kategori_utama');
            
            // Tambah kolom untuk koordinat map
            $table->decimal('latitude', 10, 8)->nullable()->after('lokasi');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            
            // Ubah kolom kategori lama (akan dihapus setelah data dimigrate)
            $table->dropColumn('kategori');
        });
    }

    public function down()
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->dropColumn(['kategori_utama', 'sub_kategori', 'latitude', 'longitude']);
            $table->enum('kategori', ['pencurian', 'kekerasan', 'narkoba', 'lalu_lintas', 'lainnya']);
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
        });
    }
};