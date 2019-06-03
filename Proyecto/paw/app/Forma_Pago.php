<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forma_Pago extends Model
{
    protected $table = "formas_pago";
    protected $fillable = ['id','descripcion','estado'];

    public function facturas(){
    	return $this->hasMany('App\Factura');
    }
}
