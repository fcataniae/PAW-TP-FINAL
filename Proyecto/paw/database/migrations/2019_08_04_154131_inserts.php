<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Inserts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            -- parametria y productos

            INSERT INTO `generos`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("1","Hombre","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `generos`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("2","Mujer","A","2019-06-02 00:00:00","2019-06-02 00:00:00");

            INSERT INTO `categorias`(`id`, `descripcion`, `genero_id`, `estado`, `created_at`, `updated_at`) VALUES ("1","Jeans","1","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `categorias`(`id`, `descripcion`, `genero_id`, `estado`, `created_at`, `updated_at`) VALUES ("2","Remeras","1","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `categorias`(`id`, `descripcion`, `genero_id`, `estado`, `created_at`, `updated_at`) VALUES ("3","Camperas","1","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `categorias`(`id`, `descripcion`, `genero_id`, `estado`, `created_at`, `updated_at`) VALUES ("4","Jeans","2","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `categorias`(`id`, `descripcion`, `genero_id`, `estado`, `created_at`, `updated_at`) VALUES ("5","Remeras","2","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `categorias`(`id`, `descripcion`, `genero_id`, `estado`, `created_at`, `updated_at`) VALUES ("6","Camperas","2","A","2019-06-02 00:00:00","2019-06-02 00:00:00");

            INSERT INTO `tipos`(`id`, `descripcion`, `categoria_id`, `estado`, `created_at`, `updated_at`) VALUES ("1","Chupin","1","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `tipos`(`id`, `descripcion`, `categoria_id`, `estado`, `created_at`, `updated_at`) VALUES ("2","Slim","1","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `tipos`(`id`, `descripcion`, `categoria_id`, `estado`, `created_at`, `updated_at`) VALUES ("3","Lisas","2","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `tipos`(`id`, `descripcion`, `categoria_id`, `estado`, `created_at`, `updated_at`) VALUES ("4","Rayadas","2","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `tipos`(`id`, `descripcion`, `categoria_id`, `estado`, `created_at`, `updated_at`) VALUES ("5","Cuero","3","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `tipos`(`id`, `descripcion`, `categoria_id`, `estado`, `created_at`, `updated_at`) VALUES ("6","Nylon","3","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `tipos`(`id`, `descripcion`, `categoria_id`, `estado`, `created_at`, `updated_at`) VALUES ("7","Chupin","4","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `tipos`(`id`, `descripcion`, `categoria_id`, `estado`, `created_at`, `updated_at`) VALUES ("8","Slim","4","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `tipos`(`id`, `descripcion`, `categoria_id`, `estado`, `created_at`, `updated_at`) VALUES ("9","Lisas","5","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `tipos`(`id`, `descripcion`, `categoria_id`, `estado`, `created_at`, `updated_at`) VALUES ("10","Rayadas","5","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `tipos`(`id`, `descripcion`, `categoria_id`, `estado`, `created_at`, `updated_at`) VALUES ("11","Cuero","6","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `tipos`(`id`, `descripcion`, `categoria_id`, `estado`, `created_at`, `updated_at`) VALUES ("12","Nylon","6","A","2019-06-02 00:00:00","2019-06-02 00:00:00");

            INSERT INTO `talles`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("1","28","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `talles`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("2","32","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `talles`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("3","36","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `talles`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("4","40","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `talles`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("5","44","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `talles`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("6","S","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `talles`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("7","M","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `talles`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("8","L","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `talles`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("9","X","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `talles`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("10","XL","A","2019-06-02 00:00:00","2019-06-02 00:00:00");

            INSERT INTO `productos`(`id`, `codigo`, `descripcion`, `stock`, `precio_costo`, `precio_venta`, `talle_id`, `tipo_id`, `estado`, `created_at`, `updated_at`) VALUES ("1","JECHTY44","Tyler",50,0,2310,"5","1","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `productos`(`id`, `codigo`, `descripcion`, `stock`, `precio_costo`, `precio_venta`, `talle_id`, `tipo_id`, `estado`, `created_at`, `updated_at`) VALUES ("2","JESLHO40","Holden",50,0,2500,"4","2","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `productos`(`id`, `codigo`, `descripcion`, `stock`, `precio_costo`, `precio_venta`, `talle_id`, `tipo_id`, `estado`, `created_at`, `updated_at`) VALUES ("3","RELIFOM","Fortaleza",50,0,400,"7","3","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `productos`(`id`, `codigo`, `descripcion`, `stock`, `precio_costo`, `precio_venta`, `talle_id`, `tipo_id`, `estado`, `created_at`, `updated_at`) VALUES ("4","RELIURX","Ural",50,0,650,"9","3","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `productos`(`id`, `codigo`, `descripcion`, `stock`, `precio_costo`, `precio_venta`, `talle_id`, `tipo_id`, `estado`, `created_at`, `updated_at`) VALUES ("5","CANYNEX","Neri",50,0,4280,"9","6","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `productos`(`id`, `codigo`, `descripcion`, `stock`, `precio_costo`, `precio_venta`, `talle_id`, `tipo_id`, `estado`, `created_at`, `updated_at`) VALUES ("6","CANYHAX","Harrison",50,0,2500,"9","6","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `productos`(`id`, `codigo`, `descripcion`, `stock`, `precio_costo`, `precio_venta`, `talle_id`, `tipo_id`, `estado`, `created_at`, `updated_at`) VALUES ("7","JECHLO28","Lolo",50,0,1700,"1","7","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `productos`(`id`, `codigo`, `descripcion`, `stock`, `precio_costo`, `precio_venta`, `talle_id`, `tipo_id`, `estado`, `created_at`, `updated_at`) VALUES ("8","JECHMA32","Maylin",50,0,1800,"2","7","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `productos`(`id`, `codigo`, `descripcion`, `stock`, `precio_costo`, `precio_venta`, `talle_id`, `tipo_id`, `estado`, `created_at`, `updated_at`) VALUES ("9","RERABRS","Brudan",50,0,450,"6","10","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `productos`(`id`, `codigo`, `descripcion`, `stock`, `precio_costo`, `precio_venta`, `talle_id`, `tipo_id`, `estado`, `created_at`, `updated_at`) VALUES ("10","RERAMOM","Mora",50,0,500,"7","10","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `productos`(`id`, `codigo`, `descripcion`, `stock`, `precio_costo`, `precio_venta`, `talle_id`, `tipo_id`, `estado`, `created_at`, `updated_at`) VALUES ("11","CACUMIM","Millie",50,0,3800,"7","11","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `productos`(`id`, `codigo`, `descripcion`, `stock`, `precio_costo`, `precio_venta`, `talle_id`, `tipo_id`, `estado`, `created_at`, `updated_at`) VALUES ("12","CANYDAM","Danae",50,0,3500,"7","12","A","2019-06-02 00:00:00","2019-06-02 00:00:00");

            INSERT INTO `formas_pago`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("1","EFECTIVO","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `formas_pago`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("2","TARJETA","A","2019-06-02 00:00:00","2019-06-02 00:00:00");

            INSERT INTO `tipos_documento` (`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("1", "DNI", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `tipos_documento` (`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("2", "CUIL", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");

            -- empleados, roles y clientes


            INSERT INTO `empleados` (`id`, `nombre`, `apellido`, `cuil`, `tipo_documento_id`, `nro_documento`, `estado`, `created_at`, `updated_at`) VALUES ("1000", "Pedro", "Guerrero", "20999999998", "1", "99999999", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `telefonos` (`id`, `empleado_id`, `tipo_telefono`, `nro_telefono`, `created_at`, `updated_at`) VALUES ("1", "1000", "fijo", "0237-4687070", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `direcciones` (`id`, `empleado_id`, `domicilio`, `localidad`, `provincia`, `pais`, `created_at`, `updated_at`) VALUES ("1", "1000", "Calle Falsa 123", "Dummy Loc 1", "Dummy Prov 1", "Dumme Pais 1", "2019-06-02 00:00:00", "2019-06-02 00:00:00");

            INSERT INTO `empleados` (`id`, `nombre`, `apellido`, `cuil`, `tipo_documento_id`, `nro_documento`, `estado`, `created_at`, `updated_at`) VALUES ("1001", "Franco", "Catania", "20888888882", "1", "88888888", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `telefonos` (`id`, `empleado_id`, `tipo_telefono`, `nro_telefono`, `created_at`, `updated_at`) VALUES ("2", "1001", "celular", "11-68686868", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `direcciones` (`id`, `empleado_id`, `domicilio`, `localidad`, `provincia`, `pais`, `created_at`, `updated_at`) VALUES ("2", "1001", "Calle Falsa 456", "Dummy Loc 2", "Dummy Prov 2", "Dumme Pais 2", "2019-06-02 00:00:00", "2019-06-02 00:00:00");

            INSERT INTO `empleados` (`id`, `nombre`, `apellido`, `cuil`, `tipo_documento_id`, `nro_documento`, `estado`, `created_at`, `updated_at`) VALUES ("1002", "Troy", "McClure", "20777777778", "1", "77777777", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `telefonos` (`id`, `empleado_id`, `tipo_telefono`, `nro_telefono`, `created_at`, `updated_at`) VALUES ("3", "1002", "fijo", "0237-6489010", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `telefonos` (`id`, `empleado_id`, `tipo_telefono`, `nro_telefono`, `created_at`, `updated_at`) VALUES ("4", "1002", "celular", "0237-6489010", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `direcciones` (`id`, `empleado_id`, `domicilio`, `localidad`, `provincia`, `pais`, `created_at`, `updated_at`) VALUES ("3", "1002", "Calle Falsa 789", "Dummy Loc 3", "Dummy Prov 3", "Dumme Pais 3", "2019-06-02 00:00:00", "2019-06-02 00:00:00");

            INSERT INTO `empleados` (`id`, `nombre`, `apellido`, `cuil`, `tipo_documento_id`, `nro_documento`, `estado`, `created_at`, `updated_at`) VALUES ("1003", "Lionel ", "Hutz", "20666666668", "1", "66666666", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `direcciones` (`id`, `empleado_id`, `domicilio`, `localidad`, `provincia`, `pais`, `created_at`, `updated_at`) VALUES ("4", "1003", "Calle Falsa 100", "Dummy Loc 4", "Dummy Prov 4", "Dumme Pais 4", "2019-06-02 00:00:00", "2019-06-02 00:00:00");

            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("1", "crear_permiso", "Crear permiso", "Permiso sobre permiso", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("2", "modificar_permiso", "Modificar permiso", "Permiso sobre permiso", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("3", "eliminar_permiso", "Eliminar permiso", "Permiso sobre permiso", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("4", "listar_permiso", "Listar permiso", "Permiso sobre permiso", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("5", "crear_rol", "Crear rol", "Permiso sobre rol", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("6", "modificar_rol", "Modificar rol", "Permiso sobre rol", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("7", "eliminar_rol", "Eliminar rol", "Permiso sobre rol", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("8", "listar_rol", "Listar rol", "Permiso sobre rol", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("9", "crear_usuario", "Crear usuario", "Permiso sobre usuario", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("10", "modificar_usuario", "Modificar usuario", "Permiso sobre usuario", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("11", "eliminar_usuario", "Eliminar usuario", "Permiso sobre usuario", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("12", "listar_usuario", "Listar usuario", "Permiso sobre usuario", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("13", "crear_empleado", "Crear empleado", "Permiso sobre empleado", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("14", "modificar_empleado", "Modificar empleado", "Permiso sobre empleado", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("15", "eliminar_empleado", "Eliminar empleado", "Permiso sobre empleado", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("16", "listar_empleado", "Listar empleado", "Permiso sobre empleado", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("17", "crear_cliente", "Crear cliente", "Permiso sobre cliente", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("18", "modificar_cliente", "Modificar cliente", "Permiso sobre cliente", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("19", "eliminar_cliente", "Eliminar cliente", "Permiso sobre cliente", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("20", "listar_cliente", "Listar cliente", "Permiso sobre cliente", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("21", "crear_forma_pago", "Crear forma pago", "Permiso sobre forma pago", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("22", "modificar_forma_pago", "Modificar forma pago", "Permiso sobre forma pago", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("23", "eliminar_forma_pago", "Eliminar forma pago", "Permiso sobre forma pago", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("24", "listar_forma_pago", "Listar forma pago", "Permiso sobre forma pagos", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("25", "crear_tipo_documento", "Crear tipo documento", "Permiso sobre tipo documento", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("26", "modificar_tipo_documento", "Modificar tipo documento", "Permiso sobre tipo documento", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("27", "eliminar_tipo_documento", "Eliminar tipo documento", "Permiso sobre tipo documento", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("28", "listar_tipo_documento", "Listar tipo documento", "Permiso sobre tipo documento", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("29", "crear_genero", "Crear genero", "Permiso sobre genero", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("30", "modificar_genero", "Modificar genero", "Permiso sobre genero", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("31", "eliminar_genero", "Eliminar genero", "Permiso sobre genero", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("32", "listar_genero", "Listar genero", "Permiso sobre genero", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("33", "crear_categoria_producto", "Crear categoria producto", "Permiso sobre categoria producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("34", "modificar_categoria_producto", "Modificar categoria producto", "Permiso sobre categoria producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("35", "eliminar_categoria_producto", "Eliminar categoria producto", "Permiso sobre categoria producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("36", "listar_categoria_producto", "Listar categoria producto", "Permiso sobre categoria producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("37", "crear_tipo_producto", "Crear tipo producto", "Permiso sobre tipo producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("38", "modificar_tipo_producto", "Modificar tipo producto", "Permiso sobre tipo producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("39", "eliminar_tipo_producto", "Eliminar tipo producto", "Permiso sobre tipo producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("40", "listar_tipo_producto", "Listar tipo producto", "Permiso sobre tipo producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("41", "crear_talle_producto", "Crear talle producto", "Permiso sobre talle producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("42", "modificar_talle_producto", "Modificar talle producto", "Permiso sobre talle producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("43", "eliminar_talle_producto", "Eliminar talle producto", "Permiso sobre talle producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("44", "listar_talle_producto", "Listar talle producto", "Permiso sobre talle producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("45", "crear_producto", "Crear producto", "Permiso sobre producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("46", "modificar_producto", "Modificar producto", "Permiso sobre producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("47", "eliminar_producto", "Eliminar producto", "Permiso sobre producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("48", "listar_producto", "Listar producto", "Permiso sobre producto", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("49", "gestionar_negocio", "Gestionar negocio", "Permiso sobre negocio", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("50", "gestionar_venta", "Gestionar venta", "Permiso sobre venta", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("51", "gestionar_inventario", "Gestionar inventario", "Permiso sobre inventario", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("52", "gestionar_reporte", "Gestionar reporte", "Permiso sobre reporte", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");

            
            INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("1", "superusuario", "superusuario", "Super Usuario", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("2", "administrador", "administrador", "Administrador", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("3", "vendedor", "vendedor", "Vendedor", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("4", "repositor", "repositor", "Repositor", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");

            INSERT INTO `users` (`id`, `name`, `email`, `password`, `estado`, `imagen`, `empleado_id`, `remember_token`, `created_at`, `updated_at`) VALUES ("1", "superuser", "superuser@example.com", "$2y$10$AUIAD4i7k839U4.9zgNc3.ICqz7gYFOcBZj.cAvyMQw8ULU2tBOAi", "A", "", "1000", "60BrUNMZIp", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `users` (`id`, `name`, `email`, `password`, `estado`, `imagen`, `empleado_id`, `remember_token`, `created_at`, `updated_at`) VALUES ("2", "administrador", "administrador@example.com", "$2y$10$AUIAD4i7k839U4.9zgNc3.ICqz7gYFOcBZj.cAvyMQw8ULU2tBOAi", "A", "", "1001", "60BrUNMZIp", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `users` (`id`, `name`, `email`, `password`, `estado`, `imagen`, `empleado_id`, `remember_token`, `created_at`, `updated_at`) VALUES ("3", "vendedor", "vendedor@example.com", "$2y$10$AUIAD4i7k839U4.9zgNc3.ICqz7gYFOcBZj.cAvyMQw8ULU2tBOAi", "A", "", "1002", "60BrUNMZIp", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `users` (`id`, `name`, `email`, `password`, `estado`, `imagen`, `empleado_id`, `remember_token`, `created_at`, `updated_at`) VALUES ("4", "repositor", "repositor@example.com", "$2y$10$AUIAD4i7k839U4.9zgNc3.ICqz7gYFOcBZj.cAvyMQw8ULU2tBOAi", "A", "", "1003", "60BrUNMZIp", "2019-06-02 00:00:00", "2019-06-02 00:00:00");

            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("1", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("2", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("3", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("4", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("5", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("6", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("7", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("8", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("9", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("10", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("11", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("12", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("13", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("14", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("15", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("16", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("17", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("18", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("19", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("20", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("21", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("22", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("23", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("24", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("25", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("26", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("27", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("28", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("29", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("30", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("31", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("32", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("33", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("34", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("35", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("36", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("37", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("38", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("39", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("40", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("41", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("42", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("43", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("44", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("45", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("46", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("47", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("48", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("49", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("50", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("51", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("52", "1");
            
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("1", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("2", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("4", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("5", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("6", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("8", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("9", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("10", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("12", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("13", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("14", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("16", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("17", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("18", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("20", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("21", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("22", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("24", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("25", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("26", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("28", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("29", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("30", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("32", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("33", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("34", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("36", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("37", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("38", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("40", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("41", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("42", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("44", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("45", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("46", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("48", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("49", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("52", "2");
            
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("50", "3");
            
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("51", "4");
            
            INSERT INTO `role_user` (`user_id`, `role_id`) VALUES ("1", "1");
            INSERT INTO `role_user` (`user_id`, `role_id`) VALUES ("2", "2");
            INSERT INTO `role_user` (`user_id`, `role_id`) VALUES ("3", "3");
            INSERT INTO `role_user` (`user_id`, `role_id`) VALUES ("4", "4");

            INSERT INTO `clientes`(`nombre`, `apellido`, `email`, `tipo_documento_id`, `nro_documento`, `estado`, `created_at`, `updated_at`) VALUES ("Homero","Simpson","dummy1@dummy.com","1","123456781","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `clientes`(`nombre`, `apellido`, `email`, `tipo_documento_id`, `nro_documento`, `estado`, `created_at`, `updated_at`) VALUES ("Apu","Nahasapeemapetilon","dummy2@dummy.com","1","123456782","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `clientes`(`nombre`, `apellido`, `email`, `tipo_documento_id`, `nro_documento`, `estado`, `created_at`, `updated_at`) VALUES ("Frank", "Grimes","dummy3@dummy.com","1","123456783","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
