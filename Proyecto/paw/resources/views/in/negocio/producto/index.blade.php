@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('head-js')
	<meta name="csrf-token" content="{{{ csrf_token() }}}">
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/filtros.js')}}"></script>
	<script src="{{asset('js/tabla.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
	<script>
		var filterUrl = "filter";
		var filters = '{!! $filtros !!}';
		document.addEventListener("DOMContentLoaded", function () {
	  		drawFilters();
	  	});
	</script>
	<script type="application/ld+json">
		{
		"@context": "https://schema.org",
		"@type": "Table",
		"about": "list of products"
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
		@if(Entrust::can('crear_producto'))
          <a href="{{ route('in.productos.crear') }}" class="button btn-azul">
            <span><i class="fa fa-plus"></i></span>
            Registrar Productos
          </a>
        @endif
		<br><br>
		<div id="filters"></div>
		<br>
		<div class="container-table">
			<div id="contenido"></div>
			<br>
			<div id="paginacion"></div>
		</div>
	</section>
@endsection