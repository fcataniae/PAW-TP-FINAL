@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/reservas.js')}}"></script>
	<script src="{{asset('js/tabla.js')}}"></script>
@endsection

@section('body-header')
	<h1 class="logo"><a href="#">Logo Tienda</a></h1>
	@include('partials.nav-principal')
@endsection
@section('body-main')

	@include('partials.alert-message')
	<section class="main">
		<p><strong>Reservas</strong></p>
		<br>
		<div id="contenido"></div>
		<br>
		<div id="paginacion"></div>
{{-- 		<div id="container-table">
			<table id="tabla" border="1" class="table">
				<!-- columnas de la tabla -->
				<thead>
					<tr>
					    <th>Nro Factura</th>
					    <th>Fecha</th>
					    <th>Importe</th>
					    <th>Emplado</th>
					    <th style="width:100px">Acción</th>
					</tr>
				</thead>
				<!-- contenido de la tabla -->
				<tbody>
					@foreach( $facturas as $factura )
				        <tr>
				    		<td id="nro_factura_{{$factura->id}}">{{$factura->id}}</td>
							<td id="fecha_{{$factura->id}}">{{date('d / m / Y', strtotime($factura->fecha_creacion))}}</td>
				          	<td id="importe_{{$factura->id}}">{{$factura->importe}}</td>
				           	<td id="empleado_{{$factura->id}}">{{$factura->empleado->nombre . " " . $factura->empleado->apellido}}</td>
				          	<td style="text-align:center">
				                <button class="button-table btn-azul">
									<a href="{{ route('in.facturas.editar', $factura->id) }}" style="color:inherit"><i class="fa fa-pencil" aria-hidden="true"></i> </a>
								</button>
								<button class="button-table btn-azul">
									<a href="{{ route('in.facturas.editar', $factura->id) }}" style="color:inherit"><i class="fa fa-pencil" aria-hidden="true"></i> </a>
								</button>
				        	</td>
		            	</tr>		
		           	@endforeach
				</tbody>
			</table>
		</div> --}}
	</section>
@endsection