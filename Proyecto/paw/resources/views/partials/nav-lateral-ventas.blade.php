<nav class="sidenav venta close no-print">
	<span class="expand">&#9776;</span>

	<ul class="unshow" >
		@if(Entrust::can('permisos_vendedor'))
			<li><a href={{ route('in.facturas.crear') }}>Venta</a></li>
		@endif

		@if(Entrust::can('permisos_vendedor'))
			<li><a href={{ route('in.facturas.reservas') }}>Reservas</a></li>
		@endif

	</ul>
</nav>
