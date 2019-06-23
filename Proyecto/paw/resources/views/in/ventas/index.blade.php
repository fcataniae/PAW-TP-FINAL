@extends('layouts.main')

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
@endsection
@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
@endsection

@section('body-header')
	<h1 class="logo"><a href="#">Logo Tienda</a></h1>
	@include('partials.nav-principal')
@endsection
@section('body-main')
	@include('partials.nav-lateral-negocio')
	<section>
		<p>Bienvenido al apartado de VENTAS {{auth()->user()->name }}</p>
	</section>
@endsection
@section('body-footer')
	<address>Guerrero, Pedro</address>
	<address>Telefono: 11235687</address>
@endsection
