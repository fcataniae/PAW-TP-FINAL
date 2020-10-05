@extends('layouts.main')

@section('head-js')
	<meta name="csrf-token" content="{{{ csrf_token() }}}">
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/ventas.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
	<script>
		var productosAll = '{!! $productos !!}';
		var factura = '{!!$factura!!}';
		var detalles = '{!!$detalles!!}';
	</script>

@endsection

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		@include('partials.alert-message')
		<div id="msjError"></div>
		@include('partials.menulayout')
		<form action="{{ route('in.facturas.gestionar')}}" method="POST" onsubmit="return enviar(event);">
			{{ csrf_field() }}

			<fieldset name="factura">
				<legend>Factura</legend>
				<label>Nro Factura: </label>
				<input type="text" id="nro_factura" name="id"  value="{{ $factura->id }}" class="input" readonly>
			</fieldset>
			<br>
			<fieldset name="Detalles">
				<legend>Productos</legend>
				<div style="margin: 10px">
					<label for="buscar_por">Producto: </label>
					<input type="text" id="valor_a_buscar" name="valor_a_buscar" list="valor_a_buscar_data" class="input">
					<datalist id="valor_a_buscar_data"></datalist>
					<input type="button" id="agregar" onClick="agregarProducto()" name="Agregar" value="Agregar" class="button-table btn-azul">
				</div>
				<!-- Tabla -->
			    <table id="tabla_detalles" border="1" class="table">
				    <!-- columnas de la tabla -->
				    <thead>
				        <tr>
				    	    <th>Genero</th>
				            <th>Categoria</th>
				            <th>Tipo</th>
				            <th>Producto</th>
				            <th>Talle</th>
				            <th>Precio</th>
				            <th>Stock</th>
				            <th style="width:150px">Cantidad</th>
				            <th>Subtotal</th>
				            <th style="width:100px">Acción</th>
				        </tr>
				    </thead>
				    <!-- contenido de la tabla -->
				    <tbody>
			        	@foreach( $detalles as $detalle )
			            <tr id="nro_detalle_{{$detalle->id}}" data-codigo="{{$detalle->producto->codigo}}">
			            	<td id="genero_{{$detalle->id}}">{{$detalle->producto->tipo->categoria->genero->descripcion}}</td>
			              	<td id="categoria_{{$detalle->id}}">{{$detalle->producto->tipo->categoria->descripcion}}</td>
			              	<td id="tipo_{{$detalle->id}}">{{$detalle->producto->tipo->descripcion}}</td>
			              	<td id="producto_{{$detalle->id}}">
			              		{{$detalle->producto->descripcion}} 
			              		<input type="hidden" name="producto_id[]" value="{{$detalle->producto->id}}">
			              	</td>
			              	<td id="talle_{{$detalle->id}}">{{$detalle->producto->talle->descripcion}}</td>
			              	<td id="precio_{{$detalle->id}}">
			              		{{$detalle->producto->precio_venta}}
			              		<input type="hidden" id="precio_x_unidad_{{$detalle->id}}" name="producto_precio[]" value="{{$detalle->producto->precio_venta}}">
			              	</td>
			              	<td id="stock_{{$detalle->id}}">{{$detalle->producto->stock + $detalle->cantidad}}</td>
			              	<td style="text-align:center">
			              		<input type="number" name="producto_cantidad[]" id="cantidad_{{$detalle->id}}" value="{{ $detalle->cantidad }}" min="0" class="input" readonly>
			              	</td>
			            	<td id="subtotal_{{$detalle->id}}" name="subtotal">{{$detalle->cantidad * $detalle->producto->precio_venta}}</td>
			            	<td style="text-align:center">
				                 <button id="editar_{{$detalle->id}}" type="button" class="button-table btn-azul" onClick="editarDetalle({{$detalle->id}})" style="display:inline;"><i class="fa fa-pencil" aria-hidden="true"></i></button>
				                 <button id="deshacer_{{$detalle->id}}" type="button" class="button-table btn-celeste" onClick="deshacerCambios({{$detalle->id}})" style="display:none;"><i class="fa fa-undo" aria-hidden="true"></i></button>
			                 	<button id="guardar_{{$detalle->id}}" type="button" class="button-table btn-verde" onClick="guardarCambios({{$detalle->id}})" style="display:none;"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
			                	<button id="eliminar_{{$detalle->id}}" type="button" class="button-table btn-rojo" onClick="eliminarDetalle({{$detalle->id}})" style="display:inline;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
				            </td>
			            </tr>
			        	@endforeach
			    	</tbody>
				</table>
			</fieldset>
			<br>
			<fieldset name="Total">
				<legend>Total</legend>
				<div align="right" style="margin-right: 10px">
					<label for="total">Total ($): </label>
					<input type="number" id="total" name="total" min="0" value="{{$factura->importe}}" class="input" readonly>
				</div>
			</fieldset>
			<br>
			<input type="submit" name="Anular" value="Anular" class="button btn-form btn-rojo">
			<input type="submit" name="Reservar" value="Reservar" class="button btn-form btn-gris">
			<input type="submit" id="submit" name="Continuar" value="Continuar" class="button btn-form btn-azul">
		</form>
	</section>
@endsection
