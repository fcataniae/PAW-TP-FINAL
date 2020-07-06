<nav class="sidenav venta close no-print">
	<div class="expand">
		<span>&#9776;</span>
		<strong class="unshow" style="margin-left: 5px">MENU</strong>
	</div>
	<ul class="unshow" >
		@if(Entrust::can('gestionar_venta'))
			<li><a href={{ route('in.facturas.crear') }}>Venta</a></li>
		@endif

		@if(Entrust::can('gestionar_venta'))
			<li><a href={{ route('in.facturas.reservas') }}>Reservas</a></li>
		@endif
	</ul>
</nav>
