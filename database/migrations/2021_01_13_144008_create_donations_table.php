<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable()->comment('Текст доната');
            $table->float('sum')->index()->comment('Сумма доната');
            $table->text('donation_sender')->nullable()->comment('Ник донатера');
            $table->unsignedBigInteger('user_to')->comment('Получатель доната');
            $table->foreign('user_to')->references('id')->on('users');
            $table->unsignedBigInteger('user_from')->comment('Отправитель доната');
            $table->foreign('user_from')->references('id')->on('users');
            $table->string('media')->nullable()->comment('Ссылка на видео');
            $table->string('speech_uri')->nullable()->comment('Ссылка на озвучку');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donates');
    }
}
