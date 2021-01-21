<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_goals', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable()->comment('Название цели');
            $table->float('sum_goal')->comment('Сумма цели');
            $table->float('start_sum')->default(0)->comment('Стартовая сумма');
            $table->unsignedBigInteger('user_id')->comment('Автор цели');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamp('complete_at')->nullable()->comment('Дата заверешения');
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
        Schema::dropIfExists('donation_goals');
    }
}
