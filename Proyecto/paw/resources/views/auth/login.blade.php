@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/login.css')}}">
@endsection

@section('body-main')
	<form method="POST" action="{{ route('auth.login') }}">
		{{csrf_field()}}
		<div class="container">
	    	<label for="name"><b>Nombre</b></label>
	    	<input type="text" name="name"  value="{{ old('name') }}" placeholder="Ingrese Nombre">
			{!! $errors->first('name', '<span> :message </span>') !!}
			<br><br>
			<label for="password"><b>Password</b></label>
			<input type="password"  name="password" placeholder="Ingrese Password">
			{!! $errors->first('password', '<span> :message </span>') !!}
			<button type="submit">Login</button>
	  	</div>
	</form>
@endsection