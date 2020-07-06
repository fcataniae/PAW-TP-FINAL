<nav class="sidenav inventario close no-print">
	<div class="expand">
		<span>&#9776;</span>
		<strong class="unshow" style="margin-left: 5px">MENU</strong>
	</div>
	<ul class="unshow">
		@if(Entrust::can('gestionar_inventario'))
			<li ><a href={{ route('in.inventario.stock') }}>Control Stock</a></li>
		@endif


	</ul>
</nav>
