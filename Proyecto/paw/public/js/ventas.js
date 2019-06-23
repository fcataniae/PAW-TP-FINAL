nroDetalle = 0;

function addDetalles(){
	var buscar_por = document.getElementById("buscar_por");
	var valor_a_buscar = document.getElementById("valor_a_buscar").value;
	console.log(valor_a_buscar);
	if(buscar_por[buscar_por.selectedIndex].id == 1){
		ajaxGet("/in/productos/" + valor_a_buscar , addCamposDetalles);
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

	var labelDescripcion = document.createElement('label');
	labelDescripcion.innerHTML = "Descripcion: ";
	var inputDescripcion = document.createElement('input');
	inputDescripcion.type = "text";
    inputDescripcion.name = "descripcion_" + nroDetalle;
    inputDescripcion.readOnly = true;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    inputDescripcion.value = producto.categoria + "," + producto.tipo +"," + producto.descripcion;
	
/*
=======
=======
>>>>>>> f74943893f5a1eba695776f71ada96c0c6a7f41b
=======
>>>>>>> f74943893f5a1eba695776f71ada96c0c6a7f41b

	var labelPrecio = document.createElement('label');
	labelPrecio.innerHTML = "Precio: ";
	var inputPrecio = document.createElement('input');
	inputPrecio.type = "number";
	inputPrecio.name = "precio_" + nroDetalle;
	inputPrecio.readOnly = true;


>>>>>>> fb09eb42fb3ba3994090a1947ca24612699021a2
	var labelTalle = document.createElement('label');
	labelTalle.innerHTML = "Talle: ";
	var selectTalle = document.createElement("select");
	selectTalle.name = "talle_" + nroDetalle;

	var array = ["S","M","X","XL"];
	for (var i = 0; i < array.length; i++) {
	    var option = document.createElement("option");
	    option.value = array[i];
	    option.text = array[i];
	    selectTalle.appendChild(option);
	}
*/
	var labelTalle = document.createElement('label');
	labelTalle.innerHTML = "Talle: ";
	var inputTalle = document.createElement('input');
	inputTalle.type = "text";
	inputTalle.name = "talle_" + nroDetalle;
	inputTalle.readOnly = true;
	inputTalle.value = producto.talle;

	var labelPrecio = document.createElement('label');
	labelPrecio.innerHTML = "Precio: ";
	var inputPrecio = document.createElement('input');
	inputPrecio.type = "number";
	inputPrecio.name = "precio_" + nroDetalle;
	inputPrecio.readOnly = true;
	inputPrecio.value = producto.precio_venta;


	var labelStock = document.createElement('label');
	labelStock.innerHTML = "Stock: ";
	var inputStock = document.createElement('input');
	inputStock.type = "number";
	inputStock.name = "stock_" + nroDetalle;
	inputStock.min = 0;
	inputStock.readOnly = true;
	inputStock.value = producto.stock;

	var labelCantidad= document.createElement('label');
	labelCantidad.innerHTML = "Cantidad: ";
	var inputCantidad = document.createElement('input');
	inputCantidad.type = "number";
	inputCantidad.name = "cantidad_" + nroDetalle;
	inputCantidad.min = 0;
	inputCantidad.value = "1";

	var labelSubtotal= document.createElement('label');
	labelSubtotal.innerHTML = "Subtotal: ";
	var inputSubtotal = document.createElement('input');
	inputSubtotal.type = "number";
	inputSubtotal.name = "subtotal_" + nroDetalle;
	inputSubtotal.min = 0;
	inputSubtotal.readOnly = true;
	inputSubtotal.value = producto.precio_venta;

	var buttonEliminar = document.createElement("button");
	buttonEliminar.type = "button";
	buttonEliminar.name = "eliminar_" + nroDetalle;
	buttonEliminar.addEventListener("click", deleteDetalle);
	buttonEliminar.innerHTML = "-";

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
}

function deleteDetalle(event){
	var detalle = document.getElementById(event.path[1].id);
	document.getElementById('formulario').removeChild(detalle);
}

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
function ajaxGet(url, callback) {
  var req = new XMLHttpRequest();
  req.open("GET", url, true);
  req.addEventListener("load", function() {
    if (req.status >= 200 && req.status < 400) {
      // Llamada ala función callback pasándole la respuesta
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
=======
=======
>>>>>>> f74943893f5a1eba695776f71ada96c0c6a7f41b
=======
>>>>>>> f74943893f5a1eba695776f71ada96c0c6a7f41b

function mostrar(respuesta) {
    console.log(respuesta);
}

function getProducto(){
	ajaxCall("GET","/in/productos/1", mostrar);
}
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> fb09eb42fb3ba3994090a1947ca24612699021a2
=======
>>>>>>> f74943893f5a1eba695776f71ada96c0c6a7f41b
=======
>>>>>>> f74943893f5a1eba695776f71ada96c0c6a7f41b
