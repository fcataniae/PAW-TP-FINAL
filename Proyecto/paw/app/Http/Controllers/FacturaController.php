<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;
use Auth;
use App\Factura as Factura;
use App\Detalle as Detalle;
use App\Cliente AS Cliente;
use App\Forma_Pago as Forma_Pago;
use App\Producto as Producto;
use App\Tipo_Documento as Tipo_Documento;
use Carbon\Carbon;
use MercadoPago;
use Log;

class FacturaController extends Controller
{
    private $mercadopagoAccessToken = "TEST-202198097498865-072823-771eef5b00a6985e46f43c8fb7e6ec05-456100370";

    public function crear()
    {
        if(Auth::user()->can('gestionar_venta')){
            $productos = $this->productosAll();
            return view('in.ventas.crear-venta')->with('productos', $productos);
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    public function gestionar(Request $request)
    {
        if(Auth::user()->can('gestionar_venta')){
            if ($request->has('Crear')) {
                return $this->iniciar($request);
            }else if ($request->has('Confirmar')) {
                return $this->finalizar($request);
            }else if ($request->has('Modificar')) {
                return $this->modificar($request);
            }else if ($request->has('Reservar')){
                return $this->reservar($request);
            }else if($request->has('Continuar')){
                return $this->continuar($request);
            }else if ($request->has('Anular')){
                return $this->anular($request);
            }
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    private function iniciar(Request $request)
    {
        if($request->producto_id == null || count($request->producto_id) == 0){
            return redirect()->back()->withErrors('No se encontraron productos asociado a la compra.');
        }

        for($i = 0; $i < count($request->producto_id); $i++){
            if($request->producto_cantidad[$i] <= 0){
               return redirect()->back()->withErrors('Se detectaron productos sin cantidad definida.'); 
            }
        }

        $nueva_factura = new Factura();
        $nueva_factura->importe = $request->total;
        $nueva_factura->fecha_creacion = Carbon::now();
        $nueva_factura->estado = "C";
        $nueva_factura->empleado_id = Auth::user()->empleado->id;
        $nueva_factura->cliente_id = null;
        $nueva_factura->forma_pago_id = null;
        if($nueva_factura->save()){
            for($i = 0; $i < count($request->producto_id); $i++){
                $nuevo_detalle = new Detalle();
                $nuevo_detalle->factura_id = $nueva_factura->id;;
                $nuevo_detalle->producto_id = $request->producto_id[$i];
                $nuevo_detalle->cantidad = $request->producto_cantidad[$i];
                $nuevo_detalle->precio_unidad = $request->producto_precio[$i];
                $nuevo_detalle->save();
            }
            return redirect()->action('FacturaController@confirmar', ['id' => $nueva_factura->id]);
        }
    }

   private function finalizar(Request $request){
        if($request->forma_pago == 1){
            $factura = Factura::find($request->id);
            if($request->efectivo < $factura->importe){
                return redirect()->back()->withErrors('El pago es menor al importe total a cobrar.');
            }
        }else if($request->forma_pago == 2){
            MercadoPago\SDK::setAccessToken($this->mercadopagoAccessToken);
            $token = $request->token;
            $payment_method_id = $request->payment_method_id;
            $installments = $request->installments;
            $issuer_id = $request->issuer_id;
            $factura = Factura::find($request->id);

            $payment = new MercadoPago\Payment();
            $payment->transaction_amount = $factura->importe;
            $payment->token = $token;
            $payment->installments = $installments;
            $payment->payment_method_id = $payment_method_id;
            $payment->issuer_id = $issuer_id;
            $payment->payer = array(
                "email" => "test_user_49142815@testuser.com"
            );

            // Guarda y postea el pago
            $payment->save();
            if($payment->id == null){
                return redirect()->back()->withErrors("Error al cobrar por Mercado Pago.");
            }else if($payment->status != "approved"){
                $payment = MercadoPago\Payment::find_by_id($payment->id);
                $payment->status = "cancelled";
                $payment->update();
                return redirect()->back()->withErrors("El pago no fue aprobado.");
            }

        }else{
            return redirect()->back()->withErrors('No se definio forma de pago.');
        }


        $factura = Factura::find($request->id);
        if($request->es_cliente == "SI" && $request->nro_cliente != null){
            $factura->cliente_id = $request->nro_cliente;
        }

        $factura->forma_pago_id = $request->forma_pago;
        $factura->estado = "F";
        if($factura->save()){
            return redirect()->action('FacturaController@comprobante', ['id' => $request->id]);
        }
    }

    public function comprobante($id){
        $factura = Factura::find($id);
        $detalles = Detalle::where('factura_id', '=', $factura->id)->orderBy('id','DESC')->get();
        return view('in.ventas.comprobante-venta')
                ->with('factura',$factura)
                ->with('detalles',$detalles);
    }

    private function modificar(Request $request)
    {
        return redirect()->action('FacturaController@editar', ['id' => $request->id]);
    }

    private function reservar(Request $request)
    {

        $factura = Factura::find($request->id);
        $factura->estado = "R";
        if($factura->save()){
            return redirect()->route('in.facturas.crear')->with('success','La solicitud ha sido reservada correctamente.');
        }
    }


    private function continuar(Request $request){
        if($request->producto_id == null || count($request->producto_id) == 0){
            return redirect()->back()->withErrors('No se encontraron productos asociado a la compra.');
        }

        for($i = 0; $i < count($request->producto_id); $i++){
            if($request->producto_cantidad[$i] <= 0){
               return redirect()->back()->withErrors('Se detectaron productos sin cantidad definida.'); 
            }
        }

        $factura = Factura::find($request->id);
        $factura->estado = "C";
        $factura->empleado_id = Auth::user()->empleado->id;
        if($factura->save()){
            Detalle::where('factura_id', '=', $factura->id)->delete();
            for($i = 0; $i < count($request->producto_id); $i++){
                $nuevo_detalle = new Detalle();
                $nuevo_detalle->factura_id = $factura->id;
                $nuevo_detalle->producto_id = $request->producto_id[$i];
                $nuevo_detalle->cantidad = $request->producto_cantidad[$i];
                $nuevo_detalle->precio_unidad = $request->producto_precio[$i];
                $nuevo_detalle->save();
            }
            return redirect()->action('FacturaController@confirmar', ['id' => $factura->id]);
        }
    }

    private function anular(Request $request)
    {
        $factura = Factura::find($request->id);
        $factura->estado = "A";
        if($factura->save()){
            return redirect()->route('in.facturas.crear')->with('success','La solicitud ha sido anulada correctamente.');
        }
    }


    public function reservas(){
        $columnas = array(
            array('headerName' => "Nro Factura", 'field' => "nro_factura"),
            array('headerName' => "Importe", 'field' => "importe"),
            array('headerName' => "Fecha", 'field' => "fecha"),
            array('headerName' => "Empleado", 'field' => "empleado"),
            array('headerName' => "Accion", 'field' => "accion", 'width' => "100px")
        );
        $columnas = json_encode($columnas);

        $facturas = Factura::where('estado', '=', 'R')->orderBy('id','ASC')->get();
        $array = array();
        $contador = 1;
        foreach($facturas as $f ){
            array_push($array,array(
                    'id' =>  $contador,
                    'dataJson' => array('nro_factura' => $f->id, 
                                        'importe' => $f->importe, 
                                        'fecha' => date("d / m / Y", strtotime($f->fecha_creacion)),
                                        'empleado' => $f->empleado->nombre . " " . $f->empleado->apellido),
                    'action' => array('update' => $f->id . "/editar")
                )
            );
            $contador++;
        }
        $facturas = json_encode($array);

        return view('in.ventas.reservas-venta')
            ->with('columnas', $columnas)
            ->with('facturas', $facturas);
    }

    public function confirmar($id){
        $factura = Factura::find($id);
        $clientesAll = Cliente::all();
        $array =array();
        foreach($clientesAll as $cliente ){
            array_push($array,array(
                    'id' =>  $cliente->id,
                    'tipo_documento_id' => $cliente->tipoDocumento->id,
                    'tipo_documento' => $cliente->tipoDocumento->descripcion,
                    'nro_documento' => $cliente->nro_documento,
                    'nombre' => $cliente->nombre,
                    'apellido' => $cliente->apellido)
                );
            }
        $clientes = json_encode($array);

        $tiposDocumento = [];
        $tiposDocumento = Tipo_Documento::orderBy('id','ASC')->where('estado', 'A')->get();

        $formapago = [];
        $formapago = Forma_Pago::orderBy('id','ASC')->where('estado', 'A')->get();         
        return view('in.ventas.confirmar-venta')
                ->with('factura',$factura)
                ->with('clientes',$clientes)
                ->with('tiposDocumento',$tiposDocumento)
                ->with('formapago',$formapago);
    }


    public function doFilter(){

        if(Auth::user()->can('gestionar_reporte')){
            $facturas = (new Factura())->newQuery();

            if(Input::get('id')){
            $facturas->where('id', '=', Input::get('id'));
            }
            if(Input::get('empleado_id')){
            $facturas->where('empleado_id', '=', Input::get('empleado_id'));
            }
            if(Input::get('importe_desde')){
            $facturas->where('importe', '>', Input::get('importe_desde'));
            }
            if(Input::get('importe_hasta')){
            $facturas->where('importe', '<', Input::get('importe_hasta'));
            }
            if(Input::get('fecha_desde')){
            $facturas->where('fecha_creacion', '>', date(Input::get('fecha_desde')));
            }
            if(Input::get('fecha_hasta')){
            $facturas->where('fecha_creacion', '<', date(Input::get('fecha_hasta')));
            }
            if(Input::get('cliente_id')){
            $facturas->where('cliente_id', '=', Input::get('cliente_id'));
            }
            if(Input::get('forma_pago_id')){
            $facturas->where('forma_pago_id', '=', Input::get('forma_pago_id'));
            }
            if(Input::get('estado')){
            $facturas->where('estado', '=', Input::get('estado'));
            }

            $columnas = array(
                array('headerName' => "Nro", 'field' => "id", 'width' => '10%'),
                array('headerName' => "Importe", 'field' => "importe", 'width' => '15%'),
                array('headerName' => "Fecha Creacion", 'field' => "fecha_creacion", 'width' => '15%'),
                array('headerName' => "Empleado", 'field' => "empleado_id", 'width' => '15%'),
                array('headerName' => "Cliente", 'field' => "cliente_id", 'width' => '15%'),
                array('headerName' => "Forma de Pago", 'field' => "forma_pago_id", 'width' => '10%'),
                array('headerName' => "Estado", 'field' => "estado", 'width' => '10%'),
            ); 
            $facturas = $facturas->get();
            $array = array();
            foreach ($facturas as $factu) {
            $cliente = '';
            $forma = '';
            if($factu->cliente != null){
                $cliente = $factu->cliente->nombre.' '.$factu->cliente->apellido;
            }
            if($factu->forma_pago_id){
                $forma = $factu->formaPago->descripcion ;
            }
            array_push($array,array(
                        'id' => $factu->id,
                        'dataJson' => array(
                            'id' =>  $factu->id,
                            'importe' => $factu->importe,
                            'cliente_id' => $cliente,
                            'empleado_id' => $factu->empleado->nombre.' '.$factu->empleado->apellido,
                            'forma_pago_id' => $forma,
                            'estado' => $factu->estado,
                            'fecha_creacion' => $factu->fecha_creacion,
                        ),
                        'action' => ''
                    ));
            }
            $data = array(
                'registros' => $array,
                'columnas' => $columnas
            );
            return json_encode($data);
        }else{
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

    public function getDetalleById($id){

        if(Auth::user()->can('gestionar_reporte')){

            $detalles = Detalle::where('factura_id', '=', $id)->orderBy('id','DESC')->get();

            $arr = array();

            foreach($detalles as $det){
                array_push($arr,
                        array(
                            'producto' => $det->producto->descripcion,
                            'codigo' => $det->producto->codigo,
                            'talle' => $det->producto->talle->descripcion,
                            'precio' => $det->precio_unidad,
                            'cantidad' => $det->cantidad
                        )
                );
            }
            return json_encode($arr);
        }else{
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }
    
    public function editar($id)
    {
        $factura = Factura::find($id);
        $detalles = Detalle::where('factura_id', '=', $factura->id)->orderBy('id','DESC')->get();
        $productos = $this->productosAll();
        return view('in.ventas.editar-venta')
                ->with('factura',$factura)
                ->with('detalles',$detalles)
                ->with('productos',$productos);
    }

    // public function actualizar(Request $request)
    // {
    //     //
    // }

    public function productosAll(){
        $productosAll = Producto::all();
        $array =array();
        foreach($productosAll as $producto ){
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

    public function updateAjax(Request $request, $id){
        Log::info("Factura a reservar por recarga de pagina, id: " . $id);
        $factura = Factura::find($id);
        $factura->estado = "R";
        $factura->save();
        return $factura->id;
    }

}
