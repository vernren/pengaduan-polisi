<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('faq', function (Blueprint $table) {
            $table->id();
            $table->text('pertanyaan');
            $table->text('jawaban');
            $table->string('kategori', 100)->nullable();
            $table->text('keywords')->nullable();
            $table->integer('view_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('kategori');
            $table->index('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('faq');
    }
};
