<nav class="sidenav">
	<span class="expand">&#9776;</span>
	
	<ul class="unshow">
		@if(Entrust::can('roles_repositor'))
			<li ><a href="#">Control Stock</a></li>
		@endif

		@if(Entrust::can('roles_repositor'))
			<li><a href="#">Reponer Stock</a></li>
		@endif

	</ul>
</nav>
