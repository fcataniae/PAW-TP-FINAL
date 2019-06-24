<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function findById($id)
    {
        $producto = Producto::find($id);

        $array  = array(    'id' =>  $producto->id,
                            'descripcion' => $producto->descripcion,
                            'stock' => $producto->stock,
                            'precio_venta' => $producto->precio_venta,
                            'talle'=> $producto->talle->descripcion,
                            'tipo' => $producto->tipo->descripcion,
                            'categoria' => $producto->tipo->categoria->descripcion);

        return json_encode($array);
    }

    public function findByCodigo($codigo)
    {
        $producto = Producto::where('codigo', '=', $codigo)->firstOrFail();

        $array  = array(    'id' =>  $producto->id,
                            'descripcion' => $producto->descripcion,
                            'stock' => $producto->stock,
                            'precio_venta' => $producto->precio_venta,
                            'talle'=> $producto->talle->descripcion,
                            'tipo' => $producto->tipo->descripcion,
                            'categoria' => $producto->tipo->categoria->descripcion);

        return json_encode($array);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

      /**
       * Display the specified resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function showAll()
      {
        
          $array = Producto::all();


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
