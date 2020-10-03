<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email', 40)->nullable();
            $table->integer('tipo_documento_id')->unsigned();
            $table->foreign('tipo_documento_id')->references('id')->on('tipos_documento');
            $table->string('nro_documento', 15)->unique();
            $table->enum('estado', ['A','I']);
            $table->timestamps();
        });

        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('cuil', 15)->unique();
            $table->integer('tipo_documento_id')->unsigned();
            $table->foreign('tipo_documento_id')->references('id')->on('tipos_documento');
            $table->string('nro_documento', 15)->unique();
            $table->enum('estado', ['A','I']);
            $table->timestamps();
        });

        DB::statement("ALTER TABLE empleados AUTO_INCREMENT = 1000;");

        Schema::create('telefonos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empleado_id')->unsigned();
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->enum('tipo_telefono', ['fijo','celular']);
            $table->string('nro_telefono');
            $table->timestamps();
        });

      Schema::create('direcciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empleado_id')->unsigned();
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->string('domicilio');
            $table->string('localidad');
            $table->string('provincia');
            $table->string('pais');
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
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('empleados');
        Schema::dropIfExists('telefonos');
        Schema::dropIfExists('direcciones');
    }
}
