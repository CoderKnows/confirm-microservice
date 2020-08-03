<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirm_code', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('Код активации');
            $table->boolean('is_active')->default(true)->comment('Активный?');
            $table->timestamps();

            $table->foreignId('object_id')->constrained('confirm_object');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('confirm_code');
    }
}
