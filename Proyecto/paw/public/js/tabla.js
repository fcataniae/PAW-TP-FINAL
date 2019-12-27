var datos = [
  {id:1, dataJson:{"nro_factura":"1000", "fecha":"10-12-13", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:2, dataJson:{"nro_factura":"1001", "fecha":"10-12-13", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:3, dataJson:{"nro_factura":"1002", "fecha":"10-12-13", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:4, dataJson:{"nro_factura":"1003", "fecha":"10-12-13", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:5, dataJson:{"nro_factura":"1004", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:6, dataJson:{"nro_factura":"1005", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:7, dataJson:{"nro_factura":"1006", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:8, dataJson:{"nro_factura":"1007", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:9, dataJson:{"nro_factura":"1008", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:10, dataJson:{"nro_factura":"1009", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:11, dataJson:{"nro_factura":"1010", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:12, dataJson:{"nro_factura":"1011", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:13, dataJson:{"nro_factura":"1012", "fecha":"10-12-15", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:14, dataJson:{"nro_factura":"1013", "fecha":"10-12-16", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:15, dataJson:{"nro_factura":"1014", "fecha":"10-12-17", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:16, dataJson:{"nro_factura":"1015", "fecha":"10-12-17", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:17, dataJson:{"nro_factura":"1016", "fecha":"10-12-17", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:18, dataJson:{"nro_factura":"1017", "fecha":"10-12-17", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:19, dataJson:{"nro_factura":"1018", "fecha":"10-12-18", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:20, dataJson:{"nro_factura":"1019", "fecha":"10-12-18", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:21, dataJson:{"nro_factura":"1020", "fecha":"10-12-18", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:22, dataJson:{"nro_factura":"1021", "fecha":"10-12-18", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:23, dataJson:{"nro_factura":"1022", "fecha":"10-12-19", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:24, dataJson:{"nro_factura":"1023", "fecha":"10-12-19", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:25, dataJson:{"nro_factura":"1024", "fecha":"10-12-19", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:26, dataJson:{"nro_factura":"1025", "fecha":"10-12-19", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:27, dataJson:{"nro_factura":"1026", "fecha":"10-12-19", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
  {id:28, dataJson:{"nro_factura":"1027", "fecha":"11-12-19", "empleado":"USA"}, action:{update:"4/editar", delete:"4/delete"}}
];

var columns = [
    {headerName: "Nro Factura", field: "nro_factura"},
    {headerName: "Fecha", field: "fecha"},
    {headerName: "Empleado", field: "empleado"},
    {headerName: "Accion", field: "accion", width: "100px"}
];

// VARIABLES Y CONSTANTES GLOBALES

var registros = [];
var registrosFiltrados = [];

var PREFIJO_FILTRO = "filtro_";
var REGISTROS_POR_PAGINA = 10;
var PAGINA_INICIAL = 0;

// LOGICA PARA TABLA

function construirTabla(columns, values) {
  var contenido = document.getElementById("contenido");
    var table = document.createElement("table");
  table.id = "customTable";
    table.className="table";
    var thead = document.createElement("thead");
    var tbody = document.createElement("tbody");
    var headRow = document.createElement("tr");
  var filters = [];
  // crea las columnas indicadas
    columns.forEach(function(el) {
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
  columns.forEach(function(el) {
    var td = document.createElement("td");
    if(el.field != "accion"){     
      td.align = "center";
      var input = document.createElement("input");
      input.type = "text";
      input.className = "input";
      input.id = PREFIJO_FILTRO + el.field;
      input.addEventListener("keyup", function(){
        registrosFiltrados = filtrar(filters, registros);
        paginarAndVisualizarRegistros(REGISTROS_POR_PAGINA, PAGINA_INICIAL);
      });
      td.appendChild(input);
    }
    tr.appendChild(td);
  });
  tbody.appendChild(tr);  
  
    table.appendChild(tbody);          
  contenido.appendChild(table); 
}

function filtrar(filters, values){
  var filtrados = [];
  var valoresFiltro = [];
  var mostrar;
  for (var i in filters){
    var value = document.getElementById(PREFIJO_FILTRO + filters[i]).value;
    valoresFiltro.push(value);
  }
  
  // recorro los registros
  for (i = 0; i < values.length; i++) {
    // recorro las columnas de un registro
    for (j = 0; j < valoresFiltro.length; j ++){
      if(values[i].dataJson[filters[j]]){
        valorFiltro = valoresFiltro[j].toUpperCase();
        valorRegistro = values[i].dataJson[filters[j]].toUpperCase();
        // comparo cada campo por el filtro cargado; si un campo no coincide no sigo comparando
        if (valorFiltro == "" || valorRegistro.indexOf(valorFiltro) > -1) {
          mostrar = true;
        } else {
          mostrar = false;
          break;
        }
      }
    }
    
    if (mostrar) {
      filtrados.push(values[i]);
    }
  }
  return filtrados;
}

function paginarAndVisualizarRegistros(num, inicio){
  var paginacion = document.getElementById("paginacion");
  var pagNow = inicio;
  var limSup;
  var numPaginasFSt = "";
  var DatoI;
  var DatoF;
  var pagAnt;
  var pagSig;
  var rutaIma=""; //Ruta base de las imagenes

  //Detecto el número "entero" de páginas
  var numPaginas = registrosFiltrados.length /num; 
  numPaginas = numPaginas.toString();
  numPaginas = numPaginas.split(".");
  numPaginasF = eval(numPaginas[0]);

  //Si el resultado de la división anterior no es exacto le añado manualmente una página más
  if (registrosFiltrados.length % num != 0){ 
    numPaginasF ++;
  }

  //Establezco el número de datos a mostrar si la última página no tiene el mismo número de datos
  if((pagNow + 1) != numPaginasF){
    limSup = -1;
  } else {
    limSup = (registrosFiltrados.length - (numPaginasF * num))-1;
  } 
  
  //Establezco el dato inicial y el dato final de la paginación
  DatoI = pagNow * num;
  DatoF = DatoI + (num+limSup);
  if (DatoF > registrosFiltrados.length){
    DatoF = registrosFiltrados.length;
  }
  
  // limpio la tabla; solo dejo los filtros
  var table = document.getElementsByTagName('table')[0];
  for(var i = table.rows.length - 1; i > 1; i--){
    table.deleteRow(i);
  }
  var tbody = table.tBodies[0];

  // agrego los registros filtrados para la pagina indicada
  agregarRegistros(tbody, registrosFiltrados, DatoI, DatoF);
  
  //Establezco cual es la página anterior y la siguiente
  if (pagNow == 0){
    pagAnt = 0;
  } else {
    pagAnt = pagNow - 1;
  }
  if (pagNow == (numPaginasF-1)){
    pagSig = pagNow;
  } else {
    pagSig = pagNow + 1;
  }
  
  paginacion.align = "center";
  paginacion.innerHTML = "";
  
  for (i=0;i<numPaginasF;i++){//Pinto la cadena con el número de páginas y sus correspondientes enlaces
    numPaginasFSt += "<a href='javascript:paginarAndVisualizarRegistros("+ num +","+ i +");'>"+ (i+1) +"</a> ";
  }
  
  var btnPrimero = document.createElement('button');
  btnPrimero.type = "button";
  btnPrimero.style.display = "inline";
  btnPrimero.className = "button-table btn-gris";
  btnPrimero.innerHTML = "<i class='fa fa-angle-double-left' aria-hidden='true' style='color:white;'></i>";
  btnPrimero.setAttribute("onclick", "paginarAndVisualizarRegistros("+ num +",0);");
  paginacion.appendChild(btnPrimero);
  
  var btnAnt = document.createElement('button');
  btnAnt.type = "button";
  btnAnt.style.display = "inline";
  btnAnt.className = "button-table btn-gris";
  btnAnt.innerHTML = "<i class='fa fa-angle-left' aria-hidden='true' style='color:white;'></i>";
  btnAnt.setAttribute("onclick", "paginarAndVisualizarRegistros("+ num +","+ pagAnt +");");
  paginacion.appendChild(btnAnt);
  
  for (i=0;i<numPaginasF;i++){//Pinto la cadena con el número de páginas y sus correspondientes enlaces
    var btnPag = document.createElement('button');
    btnPag.type = "button";
    btnPag.style.display = "inline";
    if(i != inicio){
      btnPag.className = "button-table btn-pag-noselecionado";
    }else{
      btnPag.className = "button-table btn-pag-selecionado";
    }
    btnPag.innerHTML = (i+1);
    btnPag.setAttribute("onclick", "paginarAndVisualizarRegistros("+ num +","+ i +");");
    paginacion.appendChild(btnPag);
  }
  
  var btnSig = document.createElement('button');
  btnSig.type = "button";
  btnSig.style.display = "inline";
  btnSig.className = "button-table btn-gris";
  btnSig.innerHTML = "<i class='fa fa-angle-right' aria-hidden='true' style='color:white;'></i>";
  btnSig.setAttribute("onclick", "paginarAndVisualizarRegistros("+ num +","+ pagSig +");");
  paginacion.appendChild(btnSig);
  
  var btnUltimo = document.createElement('button');
  btnUltimo.type = "button";
  btnUltimo.style.display = "inline";
  btnUltimo.className = "button-table btn-gris";
  btnUltimo.innerHTML = "<i class='fa fa-angle-double-right' aria-hidden='true' style='color:white;'></i>";
  btnUltimo.setAttribute("onclick", "paginarAndVisualizarRegistros("+ num +","+ (numPaginasF-1) +");");
  paginacion.appendChild(btnUltimo);
}

function agregarRegistros(tbody, values, DatoI, DatoF){
  // carga los datos indicados
  for (DatoI; DatoI <= DatoF; DatoI++){
    var el = values[DatoI];
    if(el){
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
    }

  }
}

document.addEventListener("DOMContentLoaded", function () {
  registros = datos;
  registrosFiltrados = datos;
  construirTabla(columns, registros);
  paginarAndVisualizarRegistros(REGISTROS_POR_PAGINA, PAGINA_INICIAL);
});