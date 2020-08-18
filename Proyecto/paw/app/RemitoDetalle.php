<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RemitoDetalle extends Model
{
    protected $table = "remito_detalle";
    protected $fillable = ['id','cantidad','producto_id', 'remito_id'];

    public function producto(){
        return $this->belongsTo('App\Producto');
    }

    public function remito(){
        return $this->belongsTo('App\Remito');
    }
}
