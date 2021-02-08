<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->unsignedBigInteger('user_id')->comment('Пользователь');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('widget_type_id')->comment('Тип виджета');
            $table->foreign('widget_type_id')->references('id')->on('widget_types');
            $table->uuid('uuid')->index()->comment('UUID виджета');
            $table->softDeletes();
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
        Schema::dropIfExists('widgets');
    }
}
