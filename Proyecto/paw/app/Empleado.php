<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = "empleados";
    protected $fillable = ['id','nombre','apellido','cuil','tipo_documento_id','nro_documento','estado'];

    public function tipoDocumento(){
      return $this->belongsTo('App\Tipo_Documento');
    }

    public function users(){
    	return $this->hasMany('App\User');
    }

    public function direcciones(){
    	return $this->hasMany('App\Direccion');
    }

    public function telefonos(){
    	return $this->hasMany('App\Telefono');
    }

    public function facturas(){
    	return $this->hasMany('App\Factura');
    }

}
