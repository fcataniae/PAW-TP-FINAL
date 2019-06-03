<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    protected $table = "generos";
    protected $fillable = ['id','descripcion','estado'];

    public function categorias(){
    	return $this->hasMany('App\Categoria');
    }
}
