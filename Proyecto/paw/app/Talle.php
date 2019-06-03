<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talle extends Model
{
    protected $table = "talles";
    protected $fillable = ['id','descripcion','estado'];

    public function productos(){
    	return $this->hasMany('App\Producto');
    }
}
