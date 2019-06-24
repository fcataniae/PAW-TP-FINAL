@extends('layouts.main')

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
@endsection

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
@endsection

@section('body-header')
	<h1 class="logo"><a href="#">Logo Tienda</a></h1>
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		<form action="{{ route('in.facturas.finalizar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="Total">
				<legend>Detalles de la compra</legend>
				<label for="total">Nro Factura: </label>
				<input type="number" id="total" name="total" min="0" readonly value= {{ $factura->id }}>
				<label for="total">Total ($): </label>
				<input type="number" id="total" name="total" min="0" readonly value= {{ $factura->importe }}>
			</fieldset>
			<br>
			<fieldset name="Buscador">
				<legend>Cliente</legend>
				<label for="es_cliente">Es cliente? </label>
				<select id="es_cliente" name="es_cliente">
				    <option id="1" value="SI">SI</option>
				    <option id="2" value="NO">NO</option>
				</select>
				<label for="nro_cliente"> Nro Cliente: </label>
				<input type="number" id="nro_cliente" name="nro_cliente">
				<label for="nro_documento">Documento: </label>
				<select id="tipo_documento" name="tipo_documento">
				    <option id="1" value="DNI">DNI</option>
				    <option id="2" value="CUIL">CUIL</option>
				</select>
				<input type="number" id="nro_documento" name="nro_documento" required="true">
				<label for="nombre"> Nombre: </label>
				<input type="text" id="nombre" name="nombre" required="true">
				<label for="apellido"> Apellido: </label>
				<input type="text" id="apellido" name="apellido" required="true">
			</fieldset>
			<br>
			<fieldset name="Detalles">
				<legend>Forma de Pago</legend>
				<div id="formulario"></div>
				<label for="forma_pago">Forma de Pago: </label>
				<select id="forma_pago" name="forma_pago">
				    <option id="1">EFECTIVO</option>
				    <option id="2">TARJETA DEBIDO</option>
				    <option id="3">TARJETA CREDITO</option>
				</select>
			</fieldset>
			<br>
			<input type="submit" value="Avanzar">
		</form>
		{{ $factura }}
	</section>
@endsection
@section('body-footer')
	<address>Guerrero, Pedro</address>
	<address>Telefono: 11235687</address>
@endsection
