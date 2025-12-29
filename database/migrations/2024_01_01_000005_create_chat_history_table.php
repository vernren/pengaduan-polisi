<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatHistoryTable extends Migration
{
    public function up()
    {
        Schema::create('chat_history', function (Blueprint $table) {
            $table->id();
            $table->text('user_message');
            $table->text('bot_reply');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_history');
    }
}
