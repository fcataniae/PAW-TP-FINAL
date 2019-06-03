<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Documento extends Model
{
    protected $table = "tipos_documento";
    protected $fillable = ['id','descripcion','estado'];

    public function empleados(){
      return $this->hasMany('App\Empleado');
    }

    public function clientes(){
      return $this->hasMany('App\Cliente');
    }
}
