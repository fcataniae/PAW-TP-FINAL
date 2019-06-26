<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock_log extends Model
{
    protected $table = "stock_log";
    protected $fillable = ['id','id_producto','stock_anterior','stock_nuevo','usuario_modificacion','comentario_usuario','fecha_creacion'];
}
