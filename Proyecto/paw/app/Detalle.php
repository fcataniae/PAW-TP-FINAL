<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    protected $table = "detalles";
    protected $fillable = ['id','cantidad','precio_unidad','factura_id','producto_id'];

    public function producto(){
        return $this->belongsTo('App\Producto');
    }

    public function factura(){
        return $this->belongsTo('App\Factura');
    }
}
