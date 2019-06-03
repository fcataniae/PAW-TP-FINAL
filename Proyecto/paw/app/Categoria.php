<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = "categorias";
    protected $fillable = ['id','descripcion','estado'];

    public function genero(){
        return $this->belongsTo('App\Genero');
    }

    public function tipos(){
    	return $this->hasMany('App\Tipo');
    }
}
