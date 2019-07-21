@if ($message = Session::get('success'))
	<div class="form-success">
		<span onclick="this.parentNode.style.display = 'none';" class="close-message">X</span>
	    <strong>{{ $message }}</strong>
	</div>
@endif


@if(count($errors))
	@foreach($errors->all() as $error)
		<div class="form-error">
			<span onclick="this.parentNode.style.display = 'none';" class="close-message">X</span>
		    <strong>{{ $error }}</strong>
		</div>
	@endforeach
@endif