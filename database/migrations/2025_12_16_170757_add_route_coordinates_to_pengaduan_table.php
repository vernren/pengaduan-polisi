<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            // Titik awal pengawalan
            $table->decimal('start_latitude', 10, 8)->nullable()->after('longitude');
            $table->decimal('start_longitude', 11, 8)->nullable()->after('start_latitude');

            // Titik akhir pengawalan
            $table->decimal('end_latitude', 10, 8)->nullable()->after('start_longitude');
            $table->decimal('end_longitude', 11, 8)->nullable()->after('end_latitude');
        });
    }

    public function down()
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->dropColumn([
                'start_latitude',
                'start_longitude',
                'end_latitude',
                'end_longitude',
            ]);
        });
    }
};
