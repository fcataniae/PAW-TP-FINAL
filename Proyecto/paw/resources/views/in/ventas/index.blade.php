@extends('layouts.main')

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
@endsection
@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
@endsection

@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section>
		<p>Bienvenido al apartado de VENTAS {{auth()->user()->name }}</p>
	</section>
@endsection
