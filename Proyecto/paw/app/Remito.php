<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remito extends Model
{
    protected $table = "remito";
    protected $fillable = ['id','importe','fecha_creacion','empleado_id','estado','image'];

    public function empleado(){
      return $this->belongsTo('App\Empleado');
    }

    public function detalles(){
    	return $this->hasMany('App\RemitoDetalle');
    }
}
