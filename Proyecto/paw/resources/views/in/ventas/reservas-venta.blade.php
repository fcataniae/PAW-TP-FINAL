@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/tabla.js')}}"></script>
	<script>
		var columnas = '{!! $columnas !!}';
		var datos = '{!! $facturas !!}';
	</script>
	<script type="application/ld+json">
		{
		"@context": "https://schema.org",
		"@type": "Table",
		"about": "list of invoices"
		}
	</script>
@endsection

@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')

	<section class="main">
		@include('partials.alert-message')
		<p><strong>Reservas</strong></p>
		<br>
		<div id="contenido"></div>
		<br>
		<div id="paginacion"></div>
	</section>
@endsection