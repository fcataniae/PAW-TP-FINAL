<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = "facturas";
    protected $fillable = ['id','importe','fecha_creacion','empleado_id','cliente_id','forma_pago_id','estado'];

    public function cliente(){
      return $this->belongsTo('App\Cliente');
    }

    public function empleado(){
      return $this->belongsTo('App\Empleado');
    }

    public function formaPago(){
      return $this->belongsTo('App\Forma_Pago');
    }

    public function detalles(){
    	return $this->hasMany('App\Detalle');
    }
}
