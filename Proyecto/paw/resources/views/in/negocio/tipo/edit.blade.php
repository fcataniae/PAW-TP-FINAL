@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script type="text/javascript">
		window.onbeforeunload = function(e) {
		  return '';
		};
	</script>
@endsection

@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		@include('partials.alert-message')
		@include('partials.menulayout')
		<form action="{{ route('in.tipos.actualizar', [$tipo->id]) }}" method="POST">
			{{method_field('PUT')}}
			{{ csrf_field() }}
			<fieldset name="tipo">
				<div class="group size-6 sangria required">
					<label>Descripcion: </label>
					<input type="text" name="descripcion" id="descripcion" value="{{ $tipo->descripcion }}" class="input size-12"  autocomplete="off">
				</div>
				<div class="group size-3 sangria required">
					<label>Categoria: </label>
					<input type="text" id="categoria" name="categoria" list="listaCategoria" value="{{ $tipo->categoria_id }}" class="input size-6" autocomplete="off">
					<datalist id="listaCategoria">
					   	@foreach($categorias as $categoria)
						    <option value="{{$categoria->id}}">{{$categoria->descripcion}}</option>
						@endforeach
					</datalist>
				</div>
				<div class="group size-2 sangria required">
					<label>Estado: </label>
					<select id="estado" name="estado" class="input">
					    <option value="A" @if($tipo->estado == 'A') selected @endif >Activo</option>
					    <option value="I" @if($tipo->estado == 'I') selected @endif >Inactivo</option>
					</select>
				</div>
			</fieldset>
			<br>
			<div align="center">
				<input type="reset" name="Restablecer" value="Restablecer" class="button btn-form btn-gris">
				<input type="submit" name="Guardar" value="Guardar" class="button btn-form btn-azul" onclick="window.onbeforeunload = null">
			</div>
		</form>
	</section>
@endsection