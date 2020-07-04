@extends('layouts.main')

@section('head-js')
	<meta name="csrf-token" content="{{{ csrf_token() }}}">
	<script src="{{asset('js/utils.js')}}"></script>
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
		<p><strong>Ticket de compra</strong></p>
		<fieldset>
			<legend>Información</legend>
			<div class="group-inline">
					<label for="id">Nro Factura: </label>
					<input type="text" id="nro_factura" name="nro_factura" class="input" value= "{{ $factura->id }}" readonly>
			</div>
			<div class="group-inline">
					<label for="fecha_creacion">Fecha: </label>
					<input type="date" id="fecha_creacion" name="fecha_creacion" class="input" value= "{{ $factura->fecha_creacion }}" readonly>
			</div>
		</fieldset>
		<br>

		@if($factura->cliente != null)
			<fieldset>
				<legend>Datos del cliente</legend>
								<div class="group-inline">
						<label for="nro_documento">Documento: </label>
						<input type="text" id="tipo_documento" name="tipo_documento" class="input" size="2" value= "{{$factura->cliente->tipoDocumento->descripcion}}" readonly>
						<input type="text" id="nro_documento" name="nro_documento" class="input" size="10" value="{{$factura->cliente->nro_documento}}" readonly>
					</div>
					<br>
					<div class="group-inline">
						<label for="nombre">Nombre: </label>
						<input type="text" id="nombre" name="nombre" class="input" value="{{$factura->cliente->nombre}}" readonly>
					</div>
					<div class="group-inline">
						<label for="apellido">Apellido: </label>
						<input type="text" id="apellido" name="apellido" class="input" value="{{$factura->cliente->apellido}}" readonly>
					</div>
			</fieldset>
			<br>
		@endif

		<fieldset>
			<legend>Detalles</legend>
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
				        <th>Precio ($)</th>
						<th>Cantidad</th>
				        <th>Subtotal ($)</th>
				    </tr>
	   			</thead>
				    <!-- contenido de la tabla -->
				    <tbody>
			        @foreach( $detalles as $detalle )
			            <tr id="nro_detalle_{{$detalle->id}}" data-codigo="{{$detalle->producto->codigo}}">
			            	<td id="genero_{{$detalle->id}}">{{$detalle->producto->tipo->categoria->genero->descripcion}}</td>
			              	<td id="categoria_{{$detalle->id}}">{{$detalle->producto->tipo->categoria->descripcion}}</td>
			              	<td id="tipo_{{$detalle->id}}">{{$detalle->producto->tipo->descripcion}}</td>
			              	<td id="producto_{{$detalle->id}}">{{$detalle->producto->descripcion}}</td>
			              	<td id="talle_{{$detalle->id}}">{{$detalle->producto->talle->descripcion}}</td>
			              	<td id="precio_{{$detalle->id}}">{{$detalle->producto->precio_venta}}</td>
			              	<td id="cantidad_{{$detalle->id}}">{{ $detalle->cantidad }}</td>
			            	<td id="subtotal_{{$detalle->id}}">{{$detalle->cantidad * $detalle->producto->precio_venta}}</td>
			            </tr>
			        @endforeach
			    	</tbody>
				</table>
			</fieldset>
			<br>

			<fieldset>
				<legend>Importe</legend>
				<div class="group-inline">
					<label for="forma_pago">Forma de Pago: </label>
					<input type="text" id="forma_pago" name="forma_pago" value="{{$factura->formaPago->descripcion}}" class="input" readonly>
				</div>
				<div class="group-inline">
					<text for="total">Total ($): </label>
				<input type="number" id="total" name="total" value="{{$factura->importe}}" class="input" readonly>
				</div>
			</fieldset>
			<br>
			<a href="{{ route('in.facturas.crear') }}" class="button btn-celeste no-print"><i class="fa fa-reply" aria-hidden="true"></i> Volver a inicio</a>
			<a onclick="window.print();" class="button btn-verde no-print"><i class="fa fa-print" aria-hidden="true"></i> Imprimir ticket</a>
	</section>
@endsection
