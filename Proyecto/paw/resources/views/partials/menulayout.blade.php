
@if(isset($title) &&  isset($subtitle) )
	<h2 class="title"> {{ $title }} <small class="no-print">{{ $subtitle }}</small></h2>
	<hr class="no-margin">
	
@endif
@isset($ruta)
	<ol class="path">
		<li><a href="{{ route($ruta) }}">{{ $subtitle }}</a>
		</li>
		<li class="active">{{ $title }} </li>
	</ol>
@endisset	