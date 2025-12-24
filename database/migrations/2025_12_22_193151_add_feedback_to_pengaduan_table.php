<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeedbackToPengaduanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->tinyInteger('rating')
                  ->nullable()
                  ->comment('Rating masyarakat 1-5');

            $table->text('feedback')
                  ->nullable()
                  ->comment('Komentar / feedback masyarakat');

            $table->timestamp('feedback_at')
                  ->nullable()
                  ->comment('Waktu feedback dikirim');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->dropColumn(['rating', 'feedback', 'feedback_at']);
        });
    }
}
