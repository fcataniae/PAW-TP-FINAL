@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('head-js')
	<meta name="csrf-token" content="{{{ csrf_token() }}}">
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/tabla.js')}}"></script>
	<script>
		var columnas = '{!! $columnas !!}';
		var datos = '{!! $registros !!}';
	</script>
	<script type="application/ld+json">
		{
		"@context": "https://schema.org",
		"@type": "Table",
		"about": "list of employees"
		}
	</script>
@endsection

@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		@include('partials.alert-message')
		@include('partials.menulayout')
		@if(Entrust::can('crear_empleado'))
          <a href="{{ route('in.empleados.crear') }}" class="button btn-azul">
            <span><i class="fa fa-plus"></i></span>
            Registrar Empleados
          </a>
        @endif
		<br>
		<div id="contenido"></div>
		<br>
		<div id="paginacion"></div>
	</section>
@endsection