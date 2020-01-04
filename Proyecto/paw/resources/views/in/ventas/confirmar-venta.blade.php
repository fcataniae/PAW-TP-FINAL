@extends('layouts.main')

@section('head-js')
	<meta name="csrf-token" content="{{{ csrf_token() }}}">
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
	<script src="{{asset('js/confirmar.js')}}"></script>
	<script>
		var clientesAll = '{!! $clientes !!}';
	</script>
@endsection

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('body-header')
	<h1 class="logo"><a href="#">Logo Tienda</a></h1>
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		@include('partials.alert-message')
		<div id="msjInfo"></div>
		<p><strong>Venta</strong></p>
		<form id="formulario" action="{{ route('in.facturas.gestionar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="Total">
				<legend>Factura</legend>
				<div class="group-inline">
					<label for="id">Nro Factura: </label>
					<input type="number" id="id" name="id" min="0" class="input" readonly value= "{{ $factura->id }}">
				</div>
				<div class="group-inline">
					<label for="total">Total ($): </label>
					<input type="number" id="total" name="total" min="0" class="input" readonly value= "{{ $factura->importe }}">
				</div>
			</fieldset>
			<br>
			<fieldset name="Buscador">
				<legend>Cliente</legend>
				<div class="group-inline">
					<label for="es_cliente">Es cliente? </label>
					<select onChange="determinarCliente()" id="es_cliente" name="es_cliente" class="input">
					    <option id="1" value="NO" selected>NO</option>
					    <option id="2" value="SI">SI</option>
					</select>
				</div>
				<div class="group-inline" id="datos_cliente" style="display:none">
					<label for="nro_cliente"> Nro Cliente: </label>
					<input type="text" id="nro_cliente" name="nro_cliente" list="clientes_data" onChange="cargarCliente()" class="input">
					<datalist id="clientes_data"></datalist>
				</div>
				<br>
				<br>
				<div class="group-inline">
					<label for="nro_documento">Documento: </label>
					<select id="tipo_documento" name="tipo_documento" class="input">
					    <option id="1" value="DNI">DNI</option>
					    <option id="2" value="CUIL">CUIL</option>
					</select>
					<input type="number" id="nro_documento" name="nro_documento" min="0" class="input">
				</div>
				<div class="group-inline">
					<label for="nombre"> Nombre: </label>
					<input type="text" id="nombre" name="nombre" class="input">
				</div>
				<div class="group-inline">
					<label for="apellido"> Apellido: </label>
					<input type="text" id="apellido" name="apellido" class="input">
				</div>
				<button id="btnAddCliente" type="button" onClick="agregarCliente()" class="button-table"><i class="fa fa-plus" aria-hidden="true"></i></button>
			</fieldset>
			<br>
			<fieldset name="Detalles">
				<legend>Forma de Pago</legend>
				<div class="group-inline">
					<label for="forma_pago">Forma de Pago: </label>
					<select id="forma_pago" name="forma_pago" onClick="definirFormaPago()" class="input">
					    <option id="1" value="1" selected>EFECTIVO</option>
					    <option id="2" value="2">TARJETA</option>
					</select>
				</div>
				<div id="forma_pago_efectivo" class="group-inline">
					<label for="efectivo">Dinero($): </label>
					<input type="number" id="efectivo" name="efectivo" min="0" class="input">
				</div>
			</fieldset>
			<br>
			<input type="submit" onclick="avanzar('Anular')" name="Anular" value="Anular" class="button btn-form btn-rojo">
			<input type="submit" onclick="avanzar('Reservar')" name="Reservar" value="Reservar" class="button btn-form btn-gris">
			<input type="submit" onclick="avanzar('Modificar')" name="Modificar" value="Modificar" class="button btn-form btn-celeste">
			<input type="button" id="Confirmar" onClick="confirmarCompra()" name="Confirmar" value="Pagar" class="button btn-form btn-azul">
		</form>
	</section>
@endsection