@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
@endsection
@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')
	@include('partials.nav-lateral-negocio')
	@include('partials.nav-lateral-inventario')
	
	<section class="main">
		<p>Bienvenido al apartado de INVENTARIO {{auth()->user()->name }}</p>
	</section>
@endsection