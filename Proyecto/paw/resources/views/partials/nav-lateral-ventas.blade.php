<nav class="sidenav">
	<span class="expand">&#9776;</span>

	<ul class="unshow" >
		@if(Entrust::can('roles_vendedor'))
			<li><a href="#">Venta</a></li>
		@endif

		@if(Entrust::can('roles_vendedor'))
			<li><a href="#">Reservas</a></li>
		@endif

	</ul>
</nav>
