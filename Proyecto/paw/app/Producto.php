<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "productos";
    protected $fillable = ['id','codigo','descripcion','stock','precio_compra','precio_venta','talle_id','tipo_id','estado'];

    public function tipo(){
        return $this->belongsTo('App\Tipo');
    }

    public function talle(){
        return $this->belongsTo('App\Talle');
    }

    public function detalles(){
    	return $this->hasMany('App\Detalle');
    }
}
