var window = window || {},
    document = document || {},
    console = console || {};

var producto = {}
var nroDetalle = 0;

function addDetalles(){
	var buscar_por = document.getElementById("buscar_por");
	var valor_a_buscar = document.getElementById("valor_a_buscar").value;
	if(buscar_por[buscar_por.selectedIndex].id == 1){
		ajaxGet("/in/productos/id/" + valor_a_buscar , addCamposDetalles);
	}else{
		ajaxGet("/in/productos/codigo/" + valor_a_buscar , addCamposDetalles);
	}
}


function addCamposDetalles(respuesta) {
	console.log(respuesta);

	var producto = JSON.parse(respuesta);
	nroDetalle++;
	var fieldset = document.createElement('fieldset');
	fieldset.id = "detalleNro_" + nroDetalle;
	fieldset.name = "detalle";
	fieldset.setAttribute("data-nroDetalle", nroDetalle);

	var inputId = document.createElement('input');
	inputId.type = "hidden";
    inputId.name = "id_" + nroDetalle;
    inputId.value = producto.id;

	var labelDescripcion = document.createElement('label');
	labelDescripcion.innerHTML = "Descripcion: ";
	var inputDescripcion = document.createElement('input');
	inputDescripcion.type = "text";
    inputDescripcion.name = "descripcion_" + nroDetalle;
    inputDescripcion.readOnly = true;
    inputDescripcion.value = producto.categoria + "," + producto.tipo +"," + producto.descripcion;

	var labelTalle = document.createElement('label');
	labelTalle.innerHTML = "Talle: ";
	var inputTalle = document.createElement('input');
	inputTalle.type = "text";
	inputTalle.name = "talle_" + nroDetalle;
	inputTalle.readOnly = true;
	inputTalle.value = producto.talle;
	inputTalle.style.width = "50px";

	var labelPrecio = document.createElement('label');
	labelPrecio.innerHTML = "Precio: ";
	var inputPrecio = document.createElement('input');
	inputPrecio.type = "number";
	inputPrecio.id = "precio_" + nroDetalle;
	inputPrecio.name = "precio_" + nroDetalle;
	inputPrecio.readOnly = true;
	inputPrecio.value = producto.precio_venta;
	inputPrecio.style.width = "75px";


	var labelStock = document.createElement('label');
	labelStock.innerHTML = "Stock: ";
	var inputStock = document.createElement('input');
	inputStock.type = "number";
	inputStock.name = "stock_" + nroDetalle;
	inputStock.min = 0;
	inputStock.readOnly = true;
	inputStock.value = producto.stock;
	inputStock.style.width = "50px";

	var labelCantidad= document.createElement('label');
	labelCantidad.innerHTML = "Cantidad: ";
	var inputCantidad = document.createElement('input');
	inputCantidad.type = "number";
	inputCantidad.id = "cantidad_" + nroDetalle;
	inputCantidad.name = "cantidad_" + nroDetalle;
	inputCantidad.min = 0;
	inputCantidad.value = 1;
	inputCantidad.addEventListener("change", calcularSubtotal);
	inputCantidad.style.width = "50px";

	var labelSubtotal= document.createElement('label');
	labelSubtotal.innerHTML = "Subtotal: ";
	var inputSubtotal = document.createElement('input');
	inputSubtotal.type = "number";
	inputSubtotal.id = "subtotal_" + nroDetalle;
	inputSubtotal.name = "subtotal_" + nroDetalle;
	inputSubtotal.min = 0;
	inputSubtotal.readOnly = true;
	inputSubtotal.value = producto.precio_venta;
	inputSubtotal.style.width = "75px";

	var buttonEliminar = document.createElement("button");
	buttonEliminar.type = "button";
	buttonEliminar.name = "eliminar_" + nroDetalle;
	buttonEliminar.addEventListener("click", deleteDetalle);
	buttonEliminar.innerHTML = "-";

	fieldset.appendChild(inputId);
	fieldset.appendChild(labelDescripcion);
	fieldset.appendChild(inputDescripcion);
	fieldset.appendChild(labelTalle);
	fieldset.appendChild(inputTalle);
	fieldset.appendChild(labelPrecio);
	fieldset.appendChild(inputPrecio);
	fieldset.appendChild(labelStock);
	fieldset.appendChild(inputStock);
	fieldset.appendChild(labelCantidad);
	fieldset.appendChild(inputCantidad);
	fieldset.appendChild(labelSubtotal);
	fieldset.appendChild(inputSubtotal);
	fieldset.appendChild(buttonEliminar);
	document.getElementById('formulario').appendChild(fieldset);
	
	calcularTotal();
}

function deleteDetalle(event){
	var detalle = document.getElementById(event.path[1].id);
	document.getElementById('formulario').removeChild(detalle);
	calcularTotal();
}

function calcularSubtotal(event){
	var nroDetalle = document.getElementById(event.path[1].id).getAttribute("data-nroDetalle");
	var cantidad = document.getElementById("cantidad_" + nroDetalle).value;
	var precio = document.getElementById("precio_" + nroDetalle).value;
	document.getElementById("subtotal_" + nroDetalle).value = cantidad * precio;
	calcularTotal();
}

function calcularTotal(){
	var detalles = document.getElementsByName("detalle");
	var total = 0;
	for(var i = 0; i < detalles.length; i++){
		nroDetalle = detalles[i].getAttribute("data-nroDetalle");
		total = total + parseInt(document.getElementById("subtotal_" + nroDetalle).value);
	}
	document.getElementById("total").value = total;
}


function ajaxGet(url, callback) {
  var req = new XMLHttpRequest();
  req.open("GET", url, true);
  req.addEventListener("load", function() {
    if (req.status >= 200 && req.status < 400) {
      callback(req.responseText);
    } else {
      console.error(req.status + " " + req.statusText);
    }
  });
  req.addEventListener("error", function(){
    console.error("Error de red");
  });
  req.send();
}

////////////////////////// CAMBIOS PARA NUEVA PANTALLA CALCULO

function buscar(){
	var buscar_por = document.getElementById("buscar_por");
	var valor_a_buscar = document.getElementById("valor_a_buscar").value;
	console.log(valor_a_buscar);
	if(valor_a_buscar){
		if(buscar_por[buscar_por.selectedIndex].id == 1){
			ajaxCallWithParametersAndRequest("GET", "/in/productos/id/" + valor_a_buscar, null, null, cargarProducto, null);
		}else{
			ajaxCallWithParametersAndRequest("GET", "/in/productos/codigo/" + valor_a_buscar ,null, null, cargarProducto, null);
		}
	}
}

function cargarProducto(respuesta) {
	producto = JSON.parse(respuesta);
	document.getElementById("descripcion").value = producto.categoria + "," + producto.tipo +"," + producto.descripcion;
	document.getElementById("talle").value = producto.talle;
	document.getElementById("precio").value = producto.precio_venta;
	document.getElementById("stock").value = producto.stock;
	document.getElementById("cantidad").value = 1;
}


function agregarDetalle(nuevaFactura){
	var cantidad = document.getElementById("cantidad").value;
	if(cantidad && producto != {}){
		producto.cantidad = cantidad;
		if(nuevaFactura){
			console.log("es nueva solicitud");
			nroDetalle++;
			agregarFila(producto,nroDetalle,true);
		}else{
			console.log("es modificacion solicitud");
			insertarDetalle(producto);
		}
	}
}

function insertarDetalle(producto){
	var nroFactura = document.getElementById("nro_factura").value;
	var request = { "factura_id": nroFactura, 
					"producto_id": producto.id, 
					"cantidad": producto.cantidad,
					"precio_venta": producto.precio_venta };
	ajaxCallWithParametersAndRequest('POST','/in/detalles', null, request,
		function(nroDetalle){
			agregarFila(producto,nroDetalle,false);
		},
		function(){		
	});
}


function agregarFila(producto, nroDetalle, nuevaFactura){
	var table  = document.getElementById("tabla_detalles");
	var row = table.insertRow();
	row.id = "nro_detalle_" + nroDetalle;
  	
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
  	
  	var talle = row.insertCell();
  	talle.id = "talle_" + nroDetalle; 
  	talle.innerHTML = producto.talle;
  	
  	var precio = row.insertCell();
  	precio.id = "precio_" + nroDetalle; 
  	precio.innerHTML = parseFloat(producto.precio_venta);
  	
  	var stock = row.insertCell();
  	stock.id = "stock_" + nroDetalle; 
  	stock.innerHTML = producto.stock;

  	var cantidad = row.insertCell(); 
  	var inputCantidad = document.createElement('input');
	inputCantidad.type = "number";
	inputCantidad.id = "cantidad_" + nroDetalle;
	inputCantidad.min = 0;
	inputCantidad.value = producto.cantidad;
	inputCantidad.readOnly = true;
  	cantidad.appendChild(inputCantidad);

  	var subtotal = row.insertCell();
  	subtotal.id = "subtotal_" + nroDetalle; 
  	subtotal.name = "subtotal";
  	subtotal.innerHTML = producto.cantidad * producto.precio_venta;

  	var accion = row.insertCell();
  	
  	var btnEditar = document.createElement('button');
  	btnEditar.id = "editar_" + nroDetalle;
  	btnEditar.type = "button";
  	btnEditar.addEventListener("click", function(){
  		editarDetalle(nroDetalle);
  	});
  	btnEditar.innerHTML = "<i class='fa fa-pencil' aria-hidden='true'></i>";
  	accion.appendChild(btnEditar);
  	
  	var btnDeshacer = document.createElement('button');
  	btnDeshacer.id = "deshacer_" + nroDetalle;
  	btnDeshacer.type = "button";
  	btnDeshacer.style.display = "none";
  	btnDeshacer.addEventListener("click", function(){
  		deshacerCambios(nroDetalle);
  	});
  	btnDeshacer.innerHTML = "<i class='fa fa-undo' aria-hidden='true'>";
  	accion.appendChild(btnDeshacer);
  	
   	var btnGuardar = document.createElement('button');
  	btnGuardar.id = "guardar_" + nroDetalle;
  	btnGuardar.type = "button";
  	btnGuardar.style.display = "none";
  	btnGuardar.addEventListener("click", function(){
  		guardarCambios(nroDetalle, nuevaFactura);
  	});
  	btnGuardar.innerHTML = "<i class='fa fa-floppy-o' aria-hidden='true'>";
  	accion.appendChild(btnGuardar);
  	
  	var btnEliminar = document.createElement('button');
  	btnEliminar.id = "eliminar_" + nroDetalle;
  	btnEliminar.type = "button";
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

function guardarCambios(id, nuevaFactura){
	
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
	});
}

function calcularSubtotal1(id){
	var cantidad = document.getElementById("cantidad_" + id).value;
	var precio = document.getElementById("precio_" + id).innerHTML;
	document.getElementById("subtotal_" + id).innerHTML = cantidad * precio;
	calcularTotal1();
}

function calcularTotal1(){
	var subtotales = document.getElementsByName("subtotal");
	var total = 0;
	for(var i = 0; i < subtotales.length; i++){
		total = total + parseInt(subtotales[i].innerHTML);
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