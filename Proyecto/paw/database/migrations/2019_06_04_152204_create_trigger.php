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
            IF(new.precio_costo > new.precio_venta OR new.precio_costo < 0 OR new.precio_venta <= 0) THEN
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
            IF(new.precio_costo > new.precio_venta OR new.precio_costo < 0 OR new.precio_venta <= 0) THEN
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
        DB::unprepared('
          CREATE TRIGGER trg_budetalle BEFORE UPDATE ON detalles
          FOR EACH ROW

          BEGIN
            IF(EXISTS (SELECT 1 FROM facturas WHERE id = old.factura_id AND estado in ("A","F"))) THEN
              SIGNAL sqlstate "45001" set message_text = "No se puede modificar el detalle de una factura FINALIZADA/ANULADA";
            END IF;
            SET new.id = old.id;
            SET new.precio_unidad = old.precio_unidad;
            SET new.factura_id = old.factura_id;
            SET new.producto_id = old.producto_id;

          END
        ');

        DB::unprepared('
          CREATE TRIGGER trg_bddetalle BEFORE DELETE
          ON detalles
          FOR EACH ROW
          BEGIN
            IF(EXISTS (SELECT 1 FROM facturas WHERE id = old.factura_id AND estado in ("F"))) THEN
              SIGNAL sqlstate "45001" set message_text = "No se puede BORRAR el detalle de una factura FINALIZADA";
            END IF;
          END
        ');
        DB::unprepared('
          CREATE TRIGGER trg_bufactura BEFORE UPDATE
          ON facturas
          FOR EACH ROW
          BEGIN
            IF (old.estado like "F" OR old.estado like "A") THEN
              SIGNAL sqlstate "45001" set message_text = "No se puede modificar una factura FINALIZADA/ANULADA";
            END IF;
            SET new.id = old.id;
            SET new.importe = old.importe;
            SET new.fecha_creacion = old.fecha_creacion;
            SET new.empleado_id = old.empleado_id;
            SET new.cliente_id = old.cliente_id;

          END
        ');
        DB::unprepared('
          CREATE TRIGGER trg_audetalle AFTER UPDATE
          ON detalles
          FOR EACH ROW
          BEGIN
            UPDATE facturas SET importe = (importe + (old.cantidad - new.cantidad) * new.precio_unidad) WHERE id = new.factura_id;
            UPDATE productos SET stock = (stock - (new.cantidad - old.cantidad)) WHERE id = new.producto_id;
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

      DB::unprepared('drop trigger trg_audetalle');
      DB::unprepared('drop trigger trg_bufactura');
      DB::unprepared('drop trigger trg_biproducto');
    }
}
