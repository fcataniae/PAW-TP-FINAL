var window = window || {},
    document = document || {},
    console = console || {};

document.addEventListener("DOMContentLoaded", function () {
	console.log(clientes);
});

function determinarCliente(){
	var esCliente = document.getElementById("es_cliente").value;
	console.log(esCliente);
	if(esCliente == "SI"){
		document.getElementById("datos_cliente").style.display = "inline-block";	
		document.getElementById("nombre").readOnly = true;
		document.getElementById("nombre").readOnly = true;
		document.getElementById("apellido").readOnly = true;
		document.getElementById("btnAddCliente").style.display = "none";	
	}else{
		document.getElementById("datos_cliente").style.display = "none";
		document.getElementById("nombre").readOnly = false;
		document.getElementById("nombre").readOnly = false;
		document.getElementById("apellido").readOnly = false;
		document.getElementById("btnAddCliente").style.display = "inline-block";
	}
}