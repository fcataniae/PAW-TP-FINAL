<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = "tipos";
    protected $fillable = ['id','descripcion','estado'];

    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }

    public function productos(){
    	return $this->hasMany('App\Producto');
    }
}
