@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">

@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/reportes.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
@endsection
@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		<div class="container-reportes">
			<div class="search-filters">
				<dialog id="fac-details"></dialog>
				<div class="form-group minified">
						<label class="padding-top" for="id">Nro</label>
						<input  class="form-input minified"
									  id="id"
									  name="id"
									  placeholder="nro"
										min="0"
									  type="number">

				</div>
				<div class="form-group minified">
						<label class="padding-top" for="importe_desde">Importe desde</label>
						<input  class="form-input minified"
										name="importe_desde"
						 				id="importe_desde"
										placeholder="importe desde"
										type="number" min="0">
				</div>
				<div class="form-group minified">
						<label class="padding-top" for="importe_hasta">Importe hasta</label>
						<input  class="form-input minified"
										name="importe_hasta"
										id="importe_hasta"
										placeholder="importe hasta" type="number" min="0">
				</div>
				<div class="form-group minified">
						<label class="padding-top" for="fecha_desde">Fecha desde</label>
						<input  class="form-input minified"
										name="fecha_desde"
										id="fecha_desde"
										placeholder="fecha desde" type="date">
				</div>
				<div class="form-group minified">
						<label class="padding-top" for="fecha_hasta">Fecha hasta</label>
						<input  class="form-input minified"
										name="fecha_hasta"
										id="fecha_hasta"
										placeholder="fecha hasta" type="date">
				</div>
				<div class="form-group minified">
						<label class="padding-top" for="empleado_id">Empleado</label>
						<input  class="form-input minified"
										id="empleado_id"
										name="empleado_id" list="empleados_data"
										placeholder="empleado id" type="text">
						<datalist id="empleados_data">
						</datalist>
				</div>
				<div class="form-group minified">
						<label class="padding-top" for="cliente_id">Cliente</label>
						<input  class="form-input minified"
										id="cliente_id"
										name="cliente_id"
										placeholder="cliente id" type="text">
				</div>
				<div class="form-group minified">
						<label class="padding-top" for="forma_pago_id">Forma de pago</label>
						<input  class="form-input minified"
										id="forma_pago_id"
										name="forma_pago_id" list="forma_pago_data"
										placeholder="forma pago" type="text">
						<datalist id="forma_pago_data">
						</datalist>
				</div>
				<div class="form-group minified">
						<label class="padding-top" for="estaod">estado</label>
						<input  class="form-input minified"
										id="estado"
										name="estado" list="estado_data"
										placeholder="estado" type="text">
						<datalist id="estado_data">
							<option value="A">Anulada</option>
							<option value="C">Creada</option>
							<option value="F">Facturada</option>
							<option value="R">Reservada</option>
						</datalist>
				</div>
				<div class="form-group minified">
					<input  type="submit" value="Filtrar" class="button-clean">
				</div>
			</div>
		</div>
	</section>
@endsection