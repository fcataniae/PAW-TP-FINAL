
var values = [
  {id:1, dataJson:{"nro_factura":"1000", "fecha":"10-12-13", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:2, dataJson:{"nro_factura":"1001", "fecha":"11-12-13", "empleado":"USA"}, action:{update:"4/editar", delete:"4/delete"}}
];
var columns = [
    {headerName: "Nro Factura", field: "nro_factura"},
    {headerName: "Fecha", field: "fecha"},
    {headerName: "Empleado", field: "empleado"},
    {headerName: "Accion", field: "accion", width: "100px"}
];

var PREFIJO_FILTRO = "filtro_";

function construirTabla(column, values) {
    var table = document.createElement("table");
  table.id = "customTable";
    table.className="table";
    var thead = document.createElement("thead");
    var tbody = document.createElement("tbody");
    var headRow = document.createElement("tr");
  var filters = [];
  // crea las columnas indicadas
    column.forEach(function(el) {
      var th=document.createElement("th");
      th.innerHTML = el.headerName;
    th.id =el.field;
    filters.push(el.field);
    if(el.width){
    th.width = el.width;
    }
      headRow.appendChild(th);
    });
    thead.appendChild(headRow);
    table.appendChild(thead);
  
  // remuevo solo el filtro de accion
  filters.splice( filters.indexOf('accion'), 1 );
  
  // crea los filtros
  var tr = document.createElement("tr");
  column.forEach(function(el) {
    var td = document.createElement("td");
    if(el.field != "accion"){     
      td.align = "center";
      var input = document.createElement("input");
      input.type = "text";
      input.className = "input";
      input.id = PREFIJO_FILTRO + el.field;
      input.addEventListener("keyup", function(){
        filtro(filters, table.id);
      });
      td.appendChild(input);
    }
    tr.appendChild(td);
  });
  tbody.appendChild(tr);  
  
  // carga los datos indicados
    values.forEach(function(el) {
      var tr = document.createElement("tr");
      for (var col in el.dataJson) {
      var td = document.createElement("td");
      td.id = col + "_" + el.id;
    td.headers = col;
      td.innerHTML = el.dataJson[col];
      tr.appendChild(td);
      }
    
    // carga las acciones indicadas
    if(el.action){
    var td = document.createElement("td");
    td.align = "center";
    if(el.action.update){
      var btnEditar = document.createElement('button');
      btnEditar.id = "editar_" + el.id;
      btnEditar.type = "button";
      btnEditar.style.display = "inline";
      btnEditar.className = "button-table btn-azul";
      var a = document.createElement('a'); 
      a.href = el.action.update;
      a.style.color = "inherit";
      a.innerHTML = "<i class='fa fa-pencil' aria-hidden='true'></i>";
      btnEditar.appendChild(a);
      td.appendChild(btnEditar);
      tr.appendChild(td);
    }
    if(el.action.delete){
      var bntEliminar = document.createElement('button');
      bntEliminar.id = "eliminar_" + el.id;
      bntEliminar.type = "button";
      bntEliminar.style.display = "inline";
      bntEliminar.className = "button-table btn-rojo";
      var a = document.createElement('a'); 
      a.href = el.action.delete;
      a.style.color = "inherit";
      a.innerHTML = "<i class='fa fa-trash-o' aria-hidden='true'></i>";
      bntEliminar.appendChild(a);
      td.appendChild(bntEliminar);
      tr.appendChild(td);
    }
    }
    
    tbody.appendChild(tr); 
    });
    table.appendChild(tbody);             
    return table;
}

function filtro(filters, tabla){
  var valoresFiltro = [];
  var mostrar;
  for (var i in filters){
    var value = document.getElementById(PREFIJO_FILTRO + filters[i]).value;
    valoresFiltro.push(value);
  }
  
  table = document.getElementById(tabla);
  tr = table.getElementsByTagName("tr");
  // recorro los registros
  for (i = 2; i < tr.length; i++) {
    // recorro las columnas de un registro
    for (j = 0; j < valoresFiltro.length; j ++){
      td = tr[i].getElementsByTagName("td")[j];
      if(td){
        valorFiltro = valoresFiltro[j].toUpperCase();
        txtValue = td.textContent || td.innerText;
        
        // comparo cada campo por el filtro cargado; si un campo no coincide no sigo comparando
        if (valorFiltro == "" || txtValue.toUpperCase().indexOf(valorFiltro) > -1) {
          mostrar = true;
        } else {
          mostrar = false;
          break;
        }
      }
    }
    
    if (mostrar) {
      tr[i].style.display = "";
    } else {
      tr[i].style.display = "none";
    }
  }
  

}

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("content").appendChild(construirTabla(columns, values));

});