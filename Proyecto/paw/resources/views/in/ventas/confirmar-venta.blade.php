@extends('layouts.main')

@section('head-js')
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
	@include('partials.nav-lateral-negocio')
	@include('partials.nav-lateral-ventas')
	<section class="main">
		@include('partials.alert-message')
		<form action="{{ route('in.facturas.gestionar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="Total">
				<legend>Factura</legend>
				<label for="id">Nro Factura: </label>
				<input type="number" id="id" name="id" min="0" readonly value= {{ $factura->id }}>
				<label for="total">Total ($): </label>
				<input type="number" id="total" name="total" min="0" readonly value= {{ $factura->importe }}>
			</fieldset>
			<br>
			<fieldset name="Buscador">
				<legend>Cliente</legend>
				<label for="es_cliente">Es cliente? </label>
				<select onChange="determinarCliente()" id="es_cliente" name="es_cliente">
				    <option id="1" value="NO" selected>NO</option>
				    <option id="2" value="SI">SI</option>
				</select>
				<div id="datos_cliente" style="display:none">
					<label for="nro_cliente"> Nro Cliente: </label>
					<input type="text" id="nro_cliente" name="nro_cliente" list="clientes_data" onChange="cargarCliente()">
					<datalist id="clientes_data"></datalist>
				</div>
				<br>
				<br>
				<label for="nro_documento">Documento: </label>
				<select id="tipo_documento" name="tipo_documento">
				    <option id="1" value="DNI">DNI</option>
				    <option id="2" value="CUIL">CUIL</option>
				</select>
				<input type="number" id="nro_documento" name="nro_documento" min="0">
				<label for="nombre"> Nombre: </label>
				<input type="text" id="nombre" name="nombre">
				<label for="apellido"> Apellido: </label>
				<input type="text" id="apellido" name="apellido">
				<button id="btnAddCliente" type="button" onClick="agregarCliente()"><i class="fa fa-plus" aria-hidden="true"></i></button>
			</fieldset>
			<br>
			<fieldset name="Detalles">
				<legend>Forma de Pago</legend>
				<div id="formulario"></div>
				<label for="forma_pago">Forma de Pago: </label>
				<select id="forma_pago" name="forma_pago">
				    <option id="1" selected>EFECTIVO</option>
				    <option id="2">TARJETA DEBIDO</option>
				    <option id="3">TARJETA CREDITO</option>
				</select>
				<div id="debito">
					
				</div>
				<div id="credito">
					
				</div>
			</fieldset>
			<br>
			<input type="submit" name="Anular" value="Anular">
			<input type="submit" name="Reservar" value="Reservar">
			<input type="submit" name="Modificar" value="Modificar">
			<input type="submit" name="Confirmar" value="Confirmar">
		</form>
	</section>
@endsection
@section('body-footer')
	<address>Guerrero, Pedro</address>
	<address>Telefono: 11235687</address>
@endsection
