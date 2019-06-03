<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
	protected $table = "telefonos";
    protected $fillable = ['id','empleado_id','tipo_telefono','nro_telefono'];

    public function empleado(){
      return $this->belongsTo('App\Empleado');
    }
}
