<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialNetworkUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_network_user', function (Blueprint $table) {
            //
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Пользователь');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('social_network_id')->comment('Социальная сеть');
            $table->foreign('social_network_id')->references('id')->on('social_networks');
            $table->string('link')->nullable()->comment('Ссылка на профиль');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_network_user');
    }
}
