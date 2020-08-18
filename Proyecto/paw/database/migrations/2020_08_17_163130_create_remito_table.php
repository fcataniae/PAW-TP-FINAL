<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemitoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('remito', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('importe', 10, 2)->default(0);
            $table->date('fecha_creacion')->useCurrent();
            $table->integer('empleado_id')->unsigned();
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->enum('estado', ['I'])->default('I');
            $table->binary('image');
            $table->timestamps();
        });

        Schema::create('remito_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->integer('remito_id')->unsigned();
            $table->foreign('remito_id')->references('id')->on('remito')->onDelete('cascade');
            $table->date('fecha_creacion')->useCurrent();
            $table->integer('producto_id')->unsigned();
            $table->foreign('producto_id')->references('id')->on('productos');
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
        Schema::dropIfExists('remito_detalle');
        Schema::dropIfExists('remito');
    }
}
