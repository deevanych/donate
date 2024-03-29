<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id')->comment('ID пользователя');
            $table->foreign('account_id')->references('id')->on('users');
            $table->unsignedBigInteger('extra_account_id')->nullable();
            $table->foreign('extra_account_id')->references('id')->on('users');
            $table->integer('amount')->comment('Сумма');
            $table->text('data')->nullable()->comment('Дополнительные данные');
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
        Schema::dropIfExists('balance_transactions');
    }
}
