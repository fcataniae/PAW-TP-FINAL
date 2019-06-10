@extends('layouts.main')


@section('body-main')
	<p>Bienvenido {{auth()->user()->name }}</p>
	<form method="POST" action="{{ route('auth.logout') }}">
		{{csrf_field()}}
			<button type="submit">Logout</button>
	  	</div>
	</form>
@endsection