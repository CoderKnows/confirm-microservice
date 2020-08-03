<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmObjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirm_object', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->comment('Идентификатор подтверждаемго объекта');
            $table->string('object')->comment('Подтверждаемый объект (email, номер телефона)');
            $table->boolean('is_confirmed')->default(false)->comment('Подтвержден?');
            $table->integer('send_count')->default(0)->comment('Количество отправок кода');
            $table->integer('try_count')->default(0)->comment('Количество попыток');
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
        Schema::dropIfExists('confirm_object');
    }
}
