var window = window || {},
    document = document || {},
    console = console || {};

var cliente = {};

document.addEventListener("DOMContentLoaded", function () {
	clientesAll = JSON.parse(clientesAll);
	console.log(clientesAll);
	cargarClientes();
});

function cargarClientes(){
	var datalist = document.getElementById("clientes_data");
	clientesAll.forEach(c => {
		option = document.createElement('option');
	    option.value =  c.id;
	    option.innerHTML = c.apellido + ", " + c.nombre;
	    datalist.appendChild(option);
	});
}

function determinarCliente(){
	var esCliente = document.getElementById("es_cliente").value;
	if(esCliente == "SI"){
		document.getElementById("datos_cliente").style.display = "inline-block";	
		document.getElementById("tipo_documento").disabled = true;
		document.getElementById("nro_documento").readOnly = true;
		document.getElementById("nombre").readOnly = true;
		document.getElementById("apellido").readOnly = true;
		document.getElementById("btnAddCliente").style.display = "none";	
	}else{
		document.getElementById("datos_cliente").style.display = "none";
		document.getElementById("tipo_documento").disabled = false;
		document.getElementById("nro_documento").readOnly = false;
		document.getElementById("nombre").readOnly = false;
		document.getElementById("apellido").readOnly = false;
		document.getElementById("btnAddCliente").style.display = "inline-block";
	}
}

function cargarCliente(){
	var nro_cliente = document.getElementById("nro_cliente").value;
	cliente = clientesAll.find(c => c.id == nro_cliente);
	document.getElementById("tipo_documento").value = cliente.tipo_documento;
	document.getElementById("nro_documento").value = cliente.nro_documento;
	document.getElementById("nombre").value = cliente.nombre;
	document.getElementById("apellido").value = cliente.apellido;
}