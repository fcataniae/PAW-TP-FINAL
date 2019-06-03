<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametriasTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 75)->unique();
            $table->enum('estado', ['A','I']);
            $table->timestamps();
        });

        Schema::create('categorias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 75)->unique();
            $table->enum('estado', ['A','I']);
            $table->timestamps();
        });

        Schema::create('tipos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 75)->unique();
            $table->enum('estado', ['A','I']);
            $table->timestamps();
        });

        Schema::create('talles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 75)->unique();
            $table->enum('estado', ['A','I']);
            $table->timestamps();
        });

        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id')->start_from(1000);
            $table->string('descripcion', 75)->unique();
            $table->integer('stock');
            $table->decimal('precio_compra', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->integer('talle_id')->unsigned();
            $table->foreign('talle_id')->references('id')->on('talles');
            $table->integer('tipo_id')->unsigned();
            $table->foreign('tipo_id')->references('id')->on('tipos');
            $table->enum('estado', ['A','I']);
            $table->timestamps();
        });

        Schema::create('formas_pago', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 75)->unique();
            $table->enum('estado', ['A','I']);
            $table->timestamps();
        });

        Schema::create('tipos_documento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 75)->unique();
            $table->enum('estado', ['A','I']);
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
        Schema::dropIfExists('generos');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('tipos');
        Schema::dropIfExists('talles');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('formas_pago');
        Schema::dropIfExists('tipos_documento');
    }
}
