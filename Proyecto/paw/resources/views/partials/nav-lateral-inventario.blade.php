<nav class="sidenav inventario">
	<span class="expand">&#9776;</span>

	<ul class="unshow">
		@if(Entrust::can('permisos_repositor'))
			<li ><a href={{ route('in.inventario.stock') }}>Control Stock</a></li>
		@endif

		@if(Entrust::can('permisos_repositor'))
			<li><a href={{ route('in.inventario.stock') }}>Reponer Stock</a></li>
		@endif

	</ul>
</nav>
