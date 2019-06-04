<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
          CREATE TRIGGER trg_budetalle BEFORE UPDATE ON detalles
          FOR EACH ROW

          BEGIN
            SIGNAL sqlstate "45001" set message_text = "No way ! You cannot do this !";
          END
        ');

        DB::unprepared('
          CREATE TRIGGER trg_bidetalle BEFORE INSERT
          ON detalles
          FOR EACH ROW
          BEGIN
            IF (NOT EXISTS (SELECT 1 FROM facturas WHERE id = new.factura_id)) THEN
                SIGNAL sqlstate "45001" set message_text = "No existe una factura con ese id!";
            END IF;

            IF (new.cantidad > (SELECT stock FROM productos WHERE id = new.producto_id) OR
                new.cantidad <= 0 OR
                NOT EXISTS(SELECT 1 FROM facturas WHERE factura_id = new.factura_id))
            THEN
                SIGNAL sqlstate "45001" set message_text = "Stock no es suficiente";
            END IF;
            IF (NOT EXISTS(SELECT stock FROM productos WHERE id = new.producto_id AND estado = "A"))
            THEN
                SIGNAL sqlstate "45001" set message_text = "El producto no se encuentra activo!";
            END IF;
            SET new.precio_unidad = (SELECT precio_venta FROM productos where id = new.producto_id);

          END
        ');
        DB::unprepared('
          CREATE TRIGGER trg_aidetalle AFTER INSERT
          ON detalles
          FOR EACH ROW
          BEGIN
            UPDATE facturas SET importe = (importe + new.cantidad * new.precio_unidad) WHERE id = new.factura_id;
            UPDATE productos SET stock = (stock - new.cantidad) WHERE id = new.producto_id;
          END
        ');
        DB::unprepared('
          CREATE TRIGGER trg_addetalle AFTER DELETE
          ON detalles
          FOR EACH ROW
          BEGIN
            UPDATE facturas SET importe = (importe - old.cantidad * old.precio_unidad) WHERE id = old.factura_id;
            UPDATE productos SET stock = (stock + old.cantidad) WHERE id = old.producto_id;
          END
        ');
        DB::unprepared('
          CREATE TRIGGER trg_bifactura BEFORE INSERT
          ON facturas
          FOR EACH ROW
          BEGIN
            SET new.importe = 0;
            SET new.estado = "C";
            SET new.fecha_creacion = CURRENT_TIMESTAMP;
          END
        ');
        DB::unprepared('
          CREATE TRIGGER trg_biproducto BEFORE INSERT
          ON productos
          FOR EACH ROW
          BEGIN
            IF(new.precio_compra > new.precio_venta OR new.precio_compra <= 0 OR new.precio_venta <= 0) THEN
                SIGNAL sqlstate "45001" set message_text = "El precio de compra debe ser menor al precio de venta!";
            END IF;
            IF(new.stock < 0) THEN
              SIGNAL sqlstate "45001" set message_text = "El stock no puede ser negativo!";
            END IF;
            IF(NOT EXISTS (SELECT 1 FROM talles WHERE id = new.talle_id AND estado = "A") OR
               NOT EXISTS (SELECT 1 FROM tipos WHERE id = new.tipo_id AND estado = "A"))
            THEN
              SIGNAL sqlstate "45001" set message_text = "El tipo/talle debe existir!";
            END IF;
          END
        ');
        DB::unprepared('
          CREATE TRIGGER trg_buproducto BEFORE UPDATE
          ON productos
          FOR EACH ROW
          BEGIN
            IF(new.precio_compra > new.precio_venta OR new.precio_compra <= 0 OR new.precio_venta <= 0) THEN
                SIGNAL sqlstate "45001" set message_text = "El precio de compra debe ser menor al precio de venta!";
            END IF;
            IF(new.stock < 0) THEN
              SIGNAL sqlstate "45001" set message_text = "El stock no puede ser negativo!";
            END IF;
            IF(NOT EXISTS (SELECT 1 FROM talles WHERE id = new.talle_id AND estado = "A") OR
               NOT EXISTS (SELECT 1 FROM tipos WHERE id = new.tipo_id AND estado = "A"))
            THEN
              SIGNAL sqlstate "45001" set message_text = "El tipo/talle debe existir!";
            END IF;
            SET new.id = old.id;
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
      DB::unprepared('drop trigger trg_budetalle');
      DB::unprepared('drop trigger trg_bidetalle');
      DB::unprepared('drop trigger trg_aidetalle');
      DB::unprepared('drop trigger trg_bifactura');
      DB::unprepared('drop trigger trg_addetalle');
      DB::unprepared('drop trigger trg_bifactura');
      DB::unprepared('drop trigger trg_biproducto');
    }
}
