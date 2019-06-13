@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}">
@endsection

@section('body-header')
	<h1 class="logo"><a href="#">Flexbox</a></h1>
	@include('partials.nav-principal')
@endsection

@section('body-main')
	<p>Bienvenido {{auth()->user()->name }}</p>
	<form method="POST" action="{{ route('auth.logout') }}">
		{{csrf_field()}}
			<button type="submit">Logout</button>
	  	</div>
	</form>
@endsection