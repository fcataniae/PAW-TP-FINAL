# Configuración y ejecución del proyecto

## pre-requisitos

* [PHP 7.2.14 instalado](https://www.php.net/releases/7_2_14.php)
* [Composer instalado](https://getcomposer.org/download/)
* [Maria DB 10.3.13 instalado](https://downloads.mariadb.org/mariadb/10.3.13/)

## configuración

* En la carpeta de instalacion de PHP agregar las siguientes lineas al archivo **_php.ini_**

```ini
extension=fileinfo
extension=pdo_mysql
```

* Ingresar a la consola de MariaDb con las credenciales correspondientes, y ejecutar el siguiente comando para crear la base de datos. (donde **_database-name_** es el nombre de la base a crear)

```sql
create database <database-name>;
```

* Renombrar el archivo **_.env.example_** por **_.env_**

* En el archivo **_.env_** cambiar los placeholder **_database-name_** (por el nombre utilizado en pasos previos), **_usuario_** y **_password_** por lo que corresponda y en caso de haber especificado un puerto distinto en la instalacion de MariaDB se debe cambiar el atributo **DB_PORT** por lo que corresponda

```.env
DB_PORT=3306
DB_DATABASE=<database-name>
DB_USERNAME=<usuario>
DB_PASSWORD=<password>
```

* En la carpeta de instalacion de PHP agregar al archivo **_php.ini_** las siguientes lineas donde **PATH_TO_CERT** debe referenciar a la ubicacion del archivo **_cacert.pem_** que se encuentra **_en la carpeta de fuentes del proyecto_**, y es utilizado para la integracion con la api de MercadoPago

```ini
curl.cainfo=PATH_TO_CERT
openssl.cafile=PATH_TO_CERT
```

## Levantar el proyecto

### sobre la carpeta **_../Proyecto/paw_** ejecutar los siguientes comandos

* Para instalar las dependencias del proyecto

```cmd
composer install
```

* Para correr las migraciones de base de datos

```cmd
php artisan migrate
```

* Para levantar el proyecto en **_puerto_** deseado

```cmd
php artisan serve --port=<puerto>
```

* Abrir una ventana del navegador y dirigirse a [**_http://localhost:puerto_**](http://localhost:puerto)
