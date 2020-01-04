@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
@endsection
@section('body-header')
	<h1 class="logo"><a href="#">Logo Tienda</a></h1>
	@include('partials.nav-principal')
@endsection
@section('body-main')

	<section class="main">

		<p><strong>Reposicion de Stock</strong></p>
    <form class="form" action="{{ route('in.inventario.update')}}" method="POST">
			{{csrf_field()}}
			<input type="hidden" name="id" id="prod-id" value="{{ $data['id']}}" required/>
			{{csrf_field()}}
			<div class="form-group">
				<label for="descripcion">Descripcion del producto</label>
				<input  disabled
								id="descripcion"
								class="form-input"
								type="text"
								name="descripcion"
								value={{$data['descripcion']}}
								required/>
			</div>
			{{csrf_field()}}
			<div class="form-group">
				<label for="stock">Stock</label>
				<input id="stock"
							 class="form-input"
							 type="number"
							 min={{$data['stock']}}
							 pattern="^[0-9]+"
							 name="stock"
							 value={{$data['stock']}}
						   required/>
			</div>
			{{csrf_field()}}
			<div class="form-group">
				<label for="talle">Talle</label>
				<input disabled
							 id="talle"
							 class="form-input"
							 type="text"
							 name="talle"
							 value={{$data['talle']}}
							 required/>
			</div>
			{{csrf_field()}}
			<div class="form-group">
				<label for="tipo">Tipo de producto</label>
				<input disabled
							 id="tipo"
							 class="form-input"
							 type="text"
							 name="tipo"
							 value={{$data['tipo']}}
							 required/>
			</div>
			{{csrf_field()}}
			<div class="form-group">
				<label for="categoria">Categoria de producto</label>
				<input disabled
							 id="categoria"
							 class="form-input"
							 type="text"
							 name="categoria"
							 value={{$data['categoria']}}
							 required/>
			</div>
			{{csrf_field()}}
			<div class="form-group">
				<label for="precio">Precio de venta</label>
				<input disabled
							 id="precio"
							 class="form-input"
							 type="text"
							 name="precio"
							 value={{$data['precio_venta']}}
							 required/>
			</div>
			{{csrf_field()}}
			<textarea class="form-area"
								type="textarea"
								name="comentario"
								rows="4"
								cols="50"
								id="comentario"
								required title="Debe agregar un comentario"/></textarea>
			{{csrf_field()}}
			<input class="form-submit"
						 type="submit"
						 name=""
						 value="Actualizar stock"/>
		</form>

		@if(count($errors))
        <div class="form-errors">
            <div class="form-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
	</section>
@endsection