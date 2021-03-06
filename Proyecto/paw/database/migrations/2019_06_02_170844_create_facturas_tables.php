<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('importe', 10, 2)->default(0);
            $table->date('fecha_creacion')->useCurrent();
            $table->integer('empleado_id')->unsigned();
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->integer('cliente_id')->nullable()->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->integer('forma_pago_id')->nullable()->unsigned();
            $table->foreign('forma_pago_id')->references('id')->on('formas_pago');
            $table->enum('estado', ['C','R','F','A'])->default('A');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE facturas AUTO_INCREMENT = 1000;");

        Schema::create('detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->decimal('precio_unidad', 10, 2);
            $table->integer('factura_id')->unsigned();
            $table->foreign('factura_id')->references('id')->on('facturas')->onDelete('cascade');
            $table->integer('producto_id')->unsigned();
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE detalles AUTO_INCREMENT = 1000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas');
        Schema::dropIfExists('detalles');
    }
}
