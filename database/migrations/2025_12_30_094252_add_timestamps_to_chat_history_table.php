<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToChatHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::table('chat_history', function (Blueprint $table) {
        if (!Schema::hasColumn('chat_history', 'updated_at')) {
            $table->timestamp('updated_at')->nullable();
        }
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    Schema::table('chat_history', function (Blueprint $table) {
        $table->dropColumn('updated_at');
    });
    }
}
