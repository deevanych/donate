<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_variations', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable()->comment('Название вариации');
            $table->text('description')->nullable()->comment('Описание вариации');
            $table->float('sum')->index()->comment('Сумма вариации');
            $table->json('appearance')->nullable()->comment('Цвет вариации');
            $table->unsignedBigInteger('user_id')->comment('Автор вариации');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('donation_variations');
    }
}
