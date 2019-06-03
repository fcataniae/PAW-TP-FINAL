<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = "direcciones";
    protected $fillable = ['id','empleado_id','domicilio','localidad','provincia','pais'];

    public function empleado(){
      return $this->belongsTo('App\Empleado');
    }
}
