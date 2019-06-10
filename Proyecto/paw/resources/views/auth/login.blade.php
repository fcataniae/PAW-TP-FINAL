@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/login.css')}}">
@endsection

@section('body-main')
	<form method="POST" action="{{ route('auth.login') }}">
		{{csrf_field()}}
		<div class="container">
	    	<label for="email"><b>E-mail</b></label>
	    	<input type="email" name="email"  value="{{ old('email') }}" placeholder="Enter E-mail">
			{!! $errors->first('email', '<span> :message </span>') !!}
			<br><br>
			<label for="password"><b>Password</b></label>
			<input type="password"  name="password" placeholder="Enter Password">
			{!! $errors->first('password', '<span> :message </span>') !!}
			<button type="submit">Login</button>
	  	</div>
	</form>
@endsection