@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
@endsection

@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		@include('partials.alert-message')
		@include('partials.menulayout')
		<form action="{{ route('in.tipos.guardar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="tipo">
				<div class="group size-8 sangria">
					<label>Descripcion: </label>
					<input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion') }}" class="input size-10"  autocomplete="off">
				</div>
				<div class="group size-3 sangria">
					<label>Categoria: </label>
					<input type="text" id="categoria" name="categoria" value="{{ old('categoria') }}" list="listaCategoria" class="input size-6" autocomplete="off">
					<datalist id="listaCategoria">
					   	@foreach($categorias as $categoria)
						    <option value="{{$categoria->id}}">{{$categoria->descripcion}}</option>
						@endforeach
					</datalist>
				</div>
			</fieldset>
			<br>
			<div align="center">
				<input type="reset" name="Borrar" value="Borrar" class="button btn-form btn-gris">
				<input type="submit" name="Crear" value="Crear" class="button btn-form btn-azul">
			</div>
		</form>
	</section>
@endsection