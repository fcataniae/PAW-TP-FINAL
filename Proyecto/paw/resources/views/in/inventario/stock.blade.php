@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">

@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/stock.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
@endsection
@section('body-header')
	<h1 class="logo"><a href="#">Logo Tienda</a></h1>
	@include('partials.nav-principal')
@endsection
@section('body-main')

	<section class="main">
		<p><strong>Control de Stock</strong></p>
		<span><strong>Filtros de busqueda:</strong></span>
		<div class="container-table">

		</div>
	</section>
	@include('partials.alert-message')
	
@endsection