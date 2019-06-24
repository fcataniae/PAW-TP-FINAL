var window = window || {},
    document = document || {},
    console = console || {};

nroDetalle = 0;

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