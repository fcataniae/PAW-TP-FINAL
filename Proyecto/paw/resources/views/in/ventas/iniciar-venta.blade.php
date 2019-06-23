@extends('layouts.main')

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/ventas.js')}}"></script>
@endsection

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
@endsection

@section('body-header')
	<h1 class="logo"><a href="#">Logo Tienda</a></h1>
	@include('partials.nav-principal')
@endsection
@section('body-main')
	@include('partials.nav-lateral-ventas')
	<section class="main">
		<form action="/ejemplo/save" method="POST">
			<fieldset name="Buscador">
				<legend>Buscador</legend>
				<label for="id_producto">BUSCAR POR </label>
				<select name="id_producto" id="id_producto">
				    <option>ID: </option>
				    <option>CODIGO: </option>
				</select>
				<input type="text" name="nombre_1" required="true">
				<input type="button" onClick="addDetalles()" value="+">
			</fieldset>
			<br>
			<fieldset name="Detalles">
				<legend>Detalles</legend>
				<div id="formulario"></div>
			</fieldset>
			<br>
			<fieldset name="Total">
				<legend>Total</legend>
				<label for="total">Total ($): </label>
				<input type="number" name="total" min="0" readonly>
			</fieldset>
			<br>
			<input type="submit" value="Enviar">
			<input type="reset" value="Limpiar">
		</form>
	</section>
@endsection
@section('body-footer')
	<address>Guerrero, Pedro</address>
	<address>Telefono: 11235687</address>
@endsection
