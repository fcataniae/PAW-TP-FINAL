<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = "clientes";
    protected $fillable = ['id','nombre','apellido','email','tipo_documento_id','nro_documento','estado'];

    public function tipoDocumento(){
      return $this->belongsTo('App\Tipo_Documento');
    }

    public function facturas(){
    	return $this->hasMany('App\Factura');
    }
}
