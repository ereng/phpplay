<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMl4afrika extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlml4afrika')
            ->create('test_types', function (Blueprint $table) {
                $table->increments('id');
                $table->string('data_element_id');
                $table->string('blis_alias');
                $table->string('name');
        });

        Schema::connection('mysqlml4afrika')
            ->create('results', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('test_type_id')->unsigned();
                $table->string('result');
        });

        Schema::connection('mysqlml4afrika')
            ->create('additionals', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('test_type_id')->unsigned();
                $table->string('type');
        });

        Schema::connection('mysqlml4afrika')
            ->create('additional_results',
                function (Blueprint $table) {
                    $table->increments('id');
                    $table->integer('additional_id')->unsigned();
                    $table->string('result');
        });

        Schema::create('ml4afrika', function (Blueprint $table) {
            $table->increments('id');
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
        Schema::dropIfExists('ml4afrika');
    }
}
