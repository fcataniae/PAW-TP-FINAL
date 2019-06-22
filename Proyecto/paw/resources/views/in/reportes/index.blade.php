@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
@endsection
@section('body-header')
	<h1 class="logo"><a href="#">Logo Tienda</a></h1>
	@include('partials.nav-principal')
@endsection
@section('body-main')
	@include('partials.nav-lateral-negocio')
	<div class="main">
		<p>Bienvenido al apartado de REPORTES {{auth()->user()->name }}</p>
		<form style="margin-left:200px;" method="POST" action="{{ route('auth.logout') }}">
			{{csrf_field()}}
				<button type="submit">Logout</button>
		  	</div>
		</form>
	</div>
@endsection
