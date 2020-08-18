<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersRemito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER trg_biremito_detalle BEFORE INSERT
        ON remito_detalle
        FOR EACH ROW
        BEGIN
            
          IF (NOT EXISTS (SELECT 1 FROM remito WHERE id = new.remito_id)) THEN
              SIGNAL sqlstate "45001" set message_text = "No existe una remito con ese id!";
          END IF;

          IF (NOT EXISTS(SELECT stock FROM productos WHERE id = new.producto_id AND estado = "A"))
          THEN
              SIGNAL sqlstate "45001" set message_text = "El producto no se encuentra activo!";
          END IF;
        END
      ');
      DB::unprepared('
      CREATE TRIGGER trg_airemito_detalle AFTER INSERT
      ON remito_detalle
      FOR EACH ROW
      BEGIN
        UPDATE productos SET stock = stock + new.cantidad WHERE id = new.producto_id;
      END
    ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop trigger trg_biremito_detalle');
        DB::unprepared('drop trigger trg_airemito_detalle');
    }
}
