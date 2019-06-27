@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/reportes.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
@endsection
@section('body-header')
	<h1 class="logo"><a href="#">Logo Tienda</a></h1>
	@include('partials.nav-principal')
@endsection
@section('body-main')
	@include('partials.nav-lateral-negocio')
	@include('partials.nav-lateral-ventas')
	@include('partials.nav-lateral-inventario')
	<section class="main">
		<div class="container-reportes">
			<div class="search-filters">
				<input class="input-search" id="id" placeholder="id" type="number">
				<input class="input-search" id="importe_desde" placeholder="importe desde" type="number" min="0">
				<input class="input-search" id="importe_hasta" placeholder="importe hasta" type="number" min="0">
				<input class="input-search" id="fecha_desde" placeholder="fecha desde" type="date">
				<input class="input-search" id="fecha_hasta" placeholder="fecha hasta" type="date">
				<input class="input-search" id="empleado_id" placeholder="empleado id" type="text">
				<input class="input-search" id="cliente_id" placeholder="cliente id" type="text">
				<input class="input-search" id="forma_pago_id" placeholder="forma pago" type="text">
				<input class="input-search" id="estado" placeholder="estado" type="text">
				<input type="submit" value="Realizar Busqueda" class="button-clean">
			</div>
		</div>
	</section>
@endsection

@section('body-footer')
	<address>Guerrero, Pedro</address>
	<address>Telefono: 11235687</address>
@endsection
