var window = window || {},
    document = document || {},
    console = console || {};

var producto = {},
	nroDetalle = 0;

document.addEventListener("DOMContentLoaded", function () {
		productosAll = JSON.parse(productosAll);
		opcionesValoresABuscar();
		// detalles = JSON.parse(detalles);
		// detalles.forEach(d => {

		// });
});

function opcionesValoresABuscar(){
	var datalist = document.getElementById("valor_a_buscar_data");
	datalist.innerHTML = "";
	productosAll.forEach(p => {
	    option = document.createElement('option');
	    option.value =  p.codigo;
	    option.innerHTML = p.categoria + ", " + p.tipo + ", " + p.descripcion + ", " + p.talle;
	    datalist.appendChild(option);
	});
};

function buscar(){
	var valor_a_buscar = document.getElementById("valor_a_buscar").value;
	if(valor_a_buscar){
		producto = productosAll.find(p => p.codigo == valor_a_buscar);
		cargarProducto(producto);
	}
}

function cargarProducto(producto) {
	document.getElementById("descripcion").value = producto.categoria + ", " + producto.tipo +", " + producto.descripcion;
	document.getElementById("talle").value = producto.talle;
	document.getElementById("precio").value = producto.precio_venta;
	document.getElementById("stock").value = producto.stock;
	document.getElementById("cantidad").value = 1;
}

function agregarDetalle(nuevaFactura){
	var cantidad = document.getElementById("cantidad").value;
	if(cantidad){
		var seleccionado = controlarProductoSeleccionado(producto);
		if(!seleccionado){
			if(cantidad <= producto.stock){
				producto.cantidad = cantidad;
				if(nuevaFactura){
					console.log("es nueva solicitud");
					nroDetalle++;
					agregarFila(producto,nroDetalle,true);
					calcularTotal1();
				}else{
					console.log("es modificacion solicitud");
					insertarDetalle(producto);
				}
				limpiarCampos();
				var error = document.getElementById('msjError');
				error.innerHTML = "";
			}else{
				indicarError("Producto sin stock suficiente.");
			}
		}else{
			indicarError("Producto ya seleccionado.");
		}
	}
}

function controlarProductoSeleccionado(producto){
	var length = document.getElementById("tabla_detalles").rows.length;
	console.log("length",length);
	var encontrado = false;
	var i = 1;
	while ( !encontrado && i < length ){
		if(producto.codigo == document.getElementById("tabla_detalles").rows[i].getAttribute("data-codigo")){
			encontrado = true;
		}
	  i++;
	}
	return encontrado;
} 

function insertarDetalle(producto){
	var nroFactura = document.getElementById("nro_factura").value;
	var request = { "factura_id": nroFactura, 
					"producto_id": producto.id, 
					"cantidad": producto.cantidad,
					"precio_venta": producto.precio_venta };
	ajaxCallWithParametersAndRequest('POST','/in/detalles', null, request,
		function(respuesta){
			var respuestaJson = JSON.parse(respuesta);
			agregarFila(producto, respuestaJson.nro_detalle, false);
			document.getElementById("total").value = respuestaJson.importe_factura;
		},
		function(){		
			indicarError("No se pudo agregar detalle.");
	});
}


function agregarFila(producto, nroDetalle, nuevaFactura){
	var table  = document.getElementById("tabla_detalles").getElementsByTagName('tbody')[0];
	var row = table.insertRow();
	row.id = "nro_detalle_" + nroDetalle;
	row.setAttribute("data-codigo", producto.codigo);
  	
  	var genero = row.insertCell();
  	genero.id = "genero_" + nroDetalle; 
  	genero.innerHTML = producto.genero;

  	var categoria = row.insertCell();
  	categoria.id = "categoria_" + nroDetalle; 
  	categoria.innerHTML = producto.categoria;

	var tipo = row.insertCell();
  	tipo.id = "tipo_" + nroDetalle; 
  	tipo.innerHTML = producto.tipo;
  	
  	let descripcion = row.insertCell();
  	descripcion.id = "producto_" + nroDetalle; 
  	descripcion.innerHTML = producto.descripcion;
  	var inputProducto = document.createElement('input');
	inputProducto.type = "hidden";
	inputProducto.name = "producto_id[]";
	inputProducto.value = producto.id;
	descripcion.appendChild(inputProducto);
  	
  	var talle = row.insertCell();
  	talle.id = "talle_" + nroDetalle; 
  	talle.innerHTML = producto.talle;
  	
  	var precio = row.insertCell();
  	precio.id = "precio_" + nroDetalle; 
  	precio.innerHTML = parseFloat(producto.precio_venta);
  	var inputPrecio = document.createElement('input');
	inputPrecio.type = "hidden";
	inputPrecio.name = "producto_precio[]" + nroDetalle;
	inputPrecio.value = parseFloat(producto.precio_venta);
	descripcion.appendChild(inputPrecio);
  	
  	var stock = row.insertCell();
  	stock.id = "stock_" + nroDetalle; 
  	stock.innerHTML = producto.stock;

  	var cantidad = row.insertCell();
  	cantidad.style.textAlign = "center"; 
  	var inputCantidad = document.createElement('input');
	inputCantidad.type = "number";
	inputCantidad.name = "producto_cantidad[]";
	inputCantidad.id = "cantidad_" + nroDetalle;
	inputCantidad.min = 0;
	inputCantidad.value = producto.cantidad;
	inputCantidad.readOnly = true;
	inputCantidad.className = "input";
  	cantidad.appendChild(inputCantidad);

  	var subtotal = row.insertCell();
  	subtotal.id = "subtotal_" + nroDetalle;
  	subtotal.innerHTML = producto.cantidad * producto.precio_venta;

  	var accion = row.insertCell();
  	accion.style.textAlign = "center";
  	
  	var btnEditar = document.createElement('button');
  	btnEditar.id = "editar_" + nroDetalle;
  	btnEditar.type = "button";
  	btnEditar.style.display = "inline";
  	btnEditar.className = "button-table btn-azul";
  	btnEditar.addEventListener("click", function(){
  		editarDetalle(nroDetalle);
  	});
  	btnEditar.innerHTML = "<i class='fa fa-pencil' aria-hidden='true'></i>";
  	accion.appendChild(btnEditar);
  	
  	var btnDeshacer = document.createElement('button');
  	btnDeshacer.id = "deshacer_" + nroDetalle;
  	btnDeshacer.type = "button";
  	btnDeshacer.style.display = "none";
  	btnDeshacer.className = "button-table btn-celeste";
  	btnDeshacer.addEventListener("click", function(){
  		deshacerCambios(nroDetalle);
  	});
  	btnDeshacer.innerHTML = "<i class='fa fa-undo' aria-hidden='true'>";
  	accion.appendChild(btnDeshacer);
  	
   	var btnGuardar = document.createElement('button');
  	btnGuardar.id = "guardar_" + nroDetalle;
  	btnGuardar.type = "button";
  	btnGuardar.style.display = "none";
  	btnGuardar.className = "button-table btn-verde";
  	btnGuardar.addEventListener("click", function(){
  		guardarCambios(nroDetalle, producto, nuevaFactura);
  	});
  	btnGuardar.innerHTML = "<i class='fa fa-floppy-o' aria-hidden='true'>";
  	accion.appendChild(btnGuardar);
  	
  	var btnEliminar = document.createElement('button');
  	btnEliminar.id = "eliminar_" + nroDetalle;
  	btnEliminar.type = "button";
  	btnEliminar.style.display = "inline";
  	btnEliminar.className = "button-table btn-rojo";
  	btnEliminar.addEventListener("click", function(){
  		eliminarDetalle(nroDetalle, nuevaFactura);
  	});
  	btnEliminar.innerHTML = "<i class='fa fa-trash-o' aria-hidden='true'></i>";
  	accion.appendChild(btnEliminar);
}

function editarDetalle(id){
	document.getElementById("cantidad_" + id).readOnly = false;
	document.getElementById("cantidad_" + id).setAttribute("data-value-old", document.getElementById("cantidad_" + id).value);
	document.getElementById("editar_" + id).style.display = "none";
	document.getElementById("eliminar_" + id).style.display = "none";
	document.getElementById("guardar_" + id).style.display = "inline";
	document.getElementById("deshacer_" + id).style.display = "inline";
}

function guardarCambios(id, producto, nuevaFactura){
	var cantidad = document.getElementById("cantidad_" + id).value;
	if(cantidad <= 0){
		indicarError("Cantidad solicitada debe ser mayor a cero.");
	}else if(cantidad <= producto.stock){
		producto.cantidad = cantidad;
		if(nuevaFactura){
			console.log("es nueva solicitud");
			calcularSubtotal1(id);
		}else{
			console.log("es modificacion solicitud");
			actualizarDetalle(id);
		}

		document.getElementById("cantidad_" + id).readOnly = true;
		document.getElementById("editar_" + id).style.display = "inline";
		document.getElementById("eliminar_" + id).style.display = "inline";
		document.getElementById("guardar_" + id).style.display = "none";
		document.getElementById("deshacer_" + id).style.display = "none";
	}else{
		indicarError("Producto sin stock suficiente.");
	}
}

function calcularSubtotal1(id){
	var cantidad = document.getElementById("cantidad_" + id).value;
	var precio = document.getElementById("precio_" + id).innerHTML;
	document.getElementById("subtotal_" + id).innerHTML = cantidad * precio;
	calcularTotal1();
}

function actualizarDetalle(id){
	var cantidad = document.getElementById("cantidad_" + id).value;
	var precio = document.getElementById("precio_" + id).innerHTML;
	var request = { "cantidad": cantidad, "precio": precio };
	ajaxCallWithParametersAndRequest('POST','/in/detalles/' + id,null,request,
		function(importe){
			document.getElementById("subtotal_" + id).innerHTML = cantidad * precio;
			document.getElementById("total").value = importe;
		},
		function(){
			document.getElementById("cantidad_" + id).readOnly = true;
			document.getElementById("cantidad_" + id).value = document.getElementById("cantidad_" + id).getAttribute("data-value-old");
			document.getElementById("editar_" + id).style.display = "inline";
			document.getElementById("eliminar_" + id).style.display = "inline";
			document.getElementById("guardar_" + id).style.display = "none";
			document.getElementById("deshacer_" + id).style.display = "none";		
			indicarError("No se pudo actualizar detalle.");
	});
}

function eliminarDetalle(id, nuevaFactura){

	if(nuevaFactura){
		console.log("es nueva solicitud");
		var detalle = document.getElementById('nro_detalle_' + id);
		detalle.parentNode.removeChild(detalle);
		calcularTotal1();
	}else{
		console.log("es modificacion solicitud");
		borrarDetalle(id);
	}
}

function borrarDetalle(id){
	ajaxCallWithParametersAndRequest('DELETE','/in/detalles/' + id + '/destroy', null, null,
		function(importe){
			var detalle = document.getElementById('nro_detalle_' + id);
			detalle.parentNode.removeChild(detalle);
			document.getElementById("total").value = importe;
		},
		function(){	
			indicarError("No se pudo eliminar detalle.");	
	});
}



function calcularTotal1(){
	var length = document.getElementById("tabla_detalles").rows.length;
	var total = 0;
	for(var i = 1; i < length; i++){
		total = total + parseInt(document.getElementById("tabla_detalles").rows[i].cells[8].innerHTML);
	}
	document.getElementById("total").value = total;
}

function deshacerCambios(id){
	document.getElementById("cantidad_" + id).readOnly = true;
	document.getElementById("cantidad_" + id).value = document.getElementById("cantidad_" + id).getAttribute("data-value-old");
	document.getElementById("editar_" + id).style.display = "inline";
	document.getElementById("eliminar_" + id).style.display = "inline";
	document.getElementById("guardar_" + id).style.display = "none";
	document.getElementById("deshacer_" + id).style.display = "none";	
}

function limpiarCampos(){
	document.getElementById("valor_a_buscar").value = null;
	document.getElementById("descripcion").value = null;
	document.getElementById("talle").value = null;
	document.getElementById("precio").value = null;
	document.getElementById("stock").value = null;
	document.getElementById("cantidad").value = null;
}

function indicarError(msjError){
	var error = document.getElementById('msjError');

	var div = document.createElement('div');
	div.className = "form-error";
	div.style.marginBottom = "10px";

	var span = document.createElement('span');
	span.className = "close-message";
	span.innerHTML = "X";
	span.onclick = function() {
	  span.parentNode.style.display = 'none';
	}

	var strong = document.createElement('strong');
	strong.innerHTML = msjError;

	div.appendChild(span);
	div.appendChild(strong);
	error.appendChild(div);
} 

