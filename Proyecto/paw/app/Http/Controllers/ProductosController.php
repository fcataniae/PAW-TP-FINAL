<?php

namespace App\Http\Controllers;

use DateTime;
use App\Producto;
use App\Stock_log;
use Illuminate\Http\Request;

class ProductosController extends Controller
{

    public function findAll()
    {
        $productos = Producto::all();

        $array =array();
        foreach($productos as $producto ){
            array_push($array,array(
                      'id' =>  $producto->id,
                      'descripcion' => $producto->descripcion,
                      'stock' => $producto->stock,
                      'precio_costo' => $producto->precio_costo,
                      'estado' => $producto->estado,
                      'codigo' => $producto->codigo,
                      'precio_venta' => $producto->precio_venta,
                      'talle'=> $producto->talle->descripcion,
                      'tipo' => $producto->tipo->descripcion,
                      'categoria' => $producto->tipo->categoria->descripcion,
                      'genero' => $producto->tipo->categoria->genero->descripcion)
                      );
        }
        return json_encode($array);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStock($id,$nuevoStock,$comentario,$user)
    {
        $producto = Producto::find($id);

        $stocklog = new Stock_log();
        $stocklog->comentario_usuario = $comentario;
        $stocklog->stock_anterior = $producto->stock;
        $stocklog->stock_nuevo = $nuevoStock;
        $stocklog->id_producto = $id;
        $stocklog->usuario_modificacion = $user;
        $stocklog->fecha_creacion = new DateTime();
        if($stocklog->save()){
          $producto->stock = $nuevoStock;
          if($producto->save()){
            return true;
          }else{
            return false;
          }
        }else{
          return false;
        }
    }

      /**
       * Display the specified resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function showAll()
      {

          $productos = Producto::all();

          $array =array();
          foreach($productos as $producto ){
            array_push($array,array(    'id' =>  $producto->id,
                      'descripcion' => $producto->descripcion,
                      'stock' => $producto->stock,
                      'precio_costo' => $producto->precio_costo,
                      'estado' => $producto->estado,
                      'codigo' => $producto->codigo,
                      'precio_venta' => $producto->precio_venta,
                      'talle_id'=> $producto->talle->descripcion,
                      'tipo_id' => $producto->tipo->descripcion,
                      'categoria' => $producto->tipo->categoria->descripcion)
                      );
          }

          return json_encode($array);
      }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
