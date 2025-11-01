<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chat_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('session_id');
            $table->text('pertanyaan');
            $table->text('jawaban');
            $table->foreignId('faq_id')->nullable()->constrained('faq')->onDelete('set null');
            $table->timestamp('created_at')->nullable();

            $table->index('session_id');
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_history');
    }
};
