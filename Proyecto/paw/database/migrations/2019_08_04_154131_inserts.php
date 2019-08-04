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

            INSERT INTO `formas_pago`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("1","Efectivo","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `formas_pago`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("2","Tarjeta Debito","A","2019-06-02 00:00:00","2019-06-02 00:00:00");
            INSERT INTO `formas_pago`(`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("3","Tarjeta Credito","A","2019-06-02 00:00:00","2019-06-02 00:00:00");

            INSERT INTO `tipos_documento` (`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES ("1", "DNI", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");

            -- empleados, roles y clientes

            INSERT INTO `empleados` (`id`, `nombre`, `apellido`, `cuil`, `tipo_documento_id`, `nro_documento`, `estado`, `created_at`, `updated_at`) VALUES ("1000", "Pedro", "Guerrero", "20999999998", "1", "99999999", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `telefonos` (`id`, `empleado_id`, `tipo_telefono`, `nro_telefono`, `created_at`, `updated_at`) VALUES ("1", "1000", "fijo", "02374687070", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `direcciones` (`id`, `empleado_id`, `domicilio`, `localidad`, `provincia`, `pais`, `created_at`, `updated_at`) VALUES ("1", "1000", "Calle Falsa 123", "Dummy Loc", "Dummy prov", "Dumme Pais", "2019-06-02 00:00:00", "2019-06-02 00:00:00");

            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("1", "permisos_administrador", "permisos_administrador", "Permisos Administrador", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("2", "permisos_vendedor", "permisos_vendedor", "Permisos Vendedor", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("3", "permisos_repositor", "permisos_repositor", "Permisos Repositor", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");

            INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("1", "superusuario", "superusuario", "Super Usuario", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("2", "administrador", "administrador", "Administrador", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("3", "vendedor", "vendedor", "Vendedor", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `estado`, `created_at`, `updated_at`) VALUES ("4", "repositor", "repositor", "Repositor", "A", "2019-06-02 00:00:00", "2019-06-02 00:00:00");

            INSERT INTO `users` (`id`, `name`, `email`, `password`, `estado`, `imagen`, `empleado_id`, `remember_token`, `created_at`, `updated_at`) VALUES ("1", "superuser", "superuser@example.com", "$2y$10$AUIAD4i7k839U4.9zgNc3.ICqz7gYFOcBZj.cAvyMQw8ULU2tBOAi", "A", "", "1000", "60BrUNMZIp", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `users` (`id`, `name`, `email`, `password`, `estado`, `imagen`, `empleado_id`, `remember_token`, `created_at`, `updated_at`) VALUES ("2", "administrador", "administrador@example.com", "$2y$10$AUIAD4i7k839U4.9zgNc3.ICqz7gYFOcBZj.cAvyMQw8ULU2tBOAi", "A", "", "1000", "60BrUNMZIp", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `users` (`id`, `name`, `email`, `password`, `estado`, `imagen`, `empleado_id`, `remember_token`, `created_at`, `updated_at`) VALUES ("3", "vendedor", "vendedor@example.com", "$2y$10$AUIAD4i7k839U4.9zgNc3.ICqz7gYFOcBZj.cAvyMQw8ULU2tBOAi", "A", "", "1000", "60BrUNMZIp", "2019-06-02 00:00:00", "2019-06-02 00:00:00");
            INSERT INTO `users` (`id`, `name`, `email`, `password`, `estado`, `imagen`, `empleado_id`, `remember_token`, `created_at`, `updated_at`) VALUES ("4", "repositor", "repositor@example.com", "$2y$10$AUIAD4i7k839U4.9zgNc3.ICqz7gYFOcBZj.cAvyMQw8ULU2tBOAi", "A", "", "1000", "60BrUNMZIp", "2019-06-02 00:00:00", "2019-06-02 00:00:00");

            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("1", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("2", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("3", "1");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("1", "2");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("2", "3");
            INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ("3", "4");
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
