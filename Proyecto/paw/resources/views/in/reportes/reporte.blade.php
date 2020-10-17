@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">

@endsection

@section('head-js')
	<script src="{{asset('js/filtros.js')}}"></script>
	<script src="{{asset('js/reportes.js')}}"></script>
	<script src="{{asset('js/tabla.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
	<script src="{{asset('js/utils.js')}}"></script>
	<script>
		var columnas;
		var datos;
		var filtros = '{!! $filtros !!}';
	</script>
	<style>
		table{
			table-layout: fixed;
		}
		td {
			word-wrap:break-word;
		}
		input {
			width: 100%;
			padding: 10px;
			margin: 0px;
		}
	</style>
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
		@include('partials.menulayout')
			<div id="filters"></div>
			<br>
		<div class="container-table">
			<div id="contenido"></div>
			<br>
			<div id="paginacion"></div>
		</div>
	</section>
@endsection