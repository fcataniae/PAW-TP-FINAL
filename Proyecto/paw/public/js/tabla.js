// var datos = [
//   {id:1, dataJson:{"nro_factura":"1000", "fecha":"10-12-13", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:2, dataJson:{"nro_factura":"1001", "fecha":"10-12-13", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:3, dataJson:{"nro_factura":"1002", "fecha":"10-12-13", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:4, dataJson:{"nro_factura":"1003", "fecha":"10-12-13", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:5, dataJson:{"nro_factura":"1004", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:6, dataJson:{"nro_factura":"1005", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:7, dataJson:{"nro_factura":"1006", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:8, dataJson:{"nro_factura":"1007", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:9, dataJson:{"nro_factura":"1008", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:10, dataJson:{"nro_factura":"1009", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:11, dataJson:{"nro_factura":"1010", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:12, dataJson:{"nro_factura":"1011", "fecha":"10-12-14", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:13, dataJson:{"nro_factura":"1012", "fecha":"10-12-15", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:14, dataJson:{"nro_factura":"1013", "fecha":"10-12-16", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:15, dataJson:{"nro_factura":"1014", "fecha":"10-12-17", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:16, dataJson:{"nro_factura":"1015", "fecha":"10-12-17", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:17, dataJson:{"nro_factura":"1016", "fecha":"10-12-17", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:18, dataJson:{"nro_factura":"1017", "fecha":"10-12-17", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:19, dataJson:{"nro_factura":"1018", "fecha":"10-12-18", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:20, dataJson:{"nro_factura":"1019", "fecha":"10-12-18", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:21, dataJson:{"nro_factura":"1020", "fecha":"10-12-18", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:22, dataJson:{"nro_factura":"1021", "fecha":"10-12-18", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:23, dataJson:{"nro_factura":"1022", "fecha":"10-12-19", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:24, dataJson:{"nro_factura":"1023", "fecha":"10-12-19", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:25, dataJson:{"nro_factura":"1024", "fecha":"10-12-19", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:26, dataJson:{"nro_factura":"1025", "fecha":"10-12-19", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:27, dataJson:{"nro_factura":"1026", "fecha":"10-12-19", "empleado":"Nepal"}, action:{update:"3/editar", delete:"3/delete"}},
//   {id:28, dataJson:{"nro_factura":"1027", "fecha":"11-12-19", "empleado":"USA"}, action:{update:"4/editar", delete:"4/delete"}}
// ];

// var columns = [
//     {headerName: "Nro Factura", field: "nro_factura"},
//     {headerName: "Fecha", field: "fecha"},
//     {headerName: "Empleado", field: "empleado"},
//     {headerName: "Accion", field: "accion", width: "100px"}
// ];

// VARIABLES Y CONSTANTES GLOBALES
var encabezados = [];
var registros = [];
var registrosFiltrados = [];
var csrf_token;
var columnas;
var datos;

var PREFIJO_FILTRO = "filtro_";
var REGISTROS_POR_PAGINA = 8;
var PAGINA_INICIAL = 0;
const PREFIJO_PLACEHOLDER = "Filtro ";
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

    // se agrega funcion para ordenar
    if(el.field != "accion"){ 

      // se agrega el font inicial a la columna correspondiente
      var i = document.createElement("i");
      i.className = "fa fa-sort";
      i.setAttribute("aria-hidden", true);
      i.setAttribute("style", "float: right; margin-right: 10px");
      th.appendChild(i);
      
      // se setea la funcion para ordenar a la columna correspondiente
      let orderAsc = false;
      th.onclick = function(){
        orderAsc = !orderAsc;
        if(orderAsc){
          i.className ="fa fa-sort-asc";
        }else{
          i.className ="fa fa-sort-desc";
        }
        ordenarTabla(el.field, orderAsc);
      }
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
      //td.align = "center";
      var input = document.createElement("input");
      input.type = "text";
      input.className = "input";
      input.id = PREFIJO_FILTRO + el.field;
      input.placeholder = PREFIJO_PLACEHOLDER + el.headerName.toLowerCase();
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
        valorFiltro = valoresFiltro[j].toString().toUpperCase();
        valorRegistro = values[i].dataJson[filters[j]].toString().toUpperCase();
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
  var pagNow = inicio;
  var limSup;
  var DatoI;
  var DatoF;
  var pagAnt;
  var pagSig;

  //Detecto el número "entero" de páginas
  var numPaginas = registrosFiltrados.length / num; 
  numPaginasF = Math.trunc(numPaginas);

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

  // agrego las paginas
  agregarPaginas(num, inicio, numPaginasF, pagAnt, pagSig);
}

function agregarRegistros(tbody, values, DatoI, DatoF){
  // carga los datos indicados
  for (DatoI; DatoI <= DatoF; DatoI++){
    let el = values[DatoI];
    if(el){
      let tr = document.createElement("tr");
      encabezados.forEach(col =>  {
        field = col.field;
        if(field in el.dataJson){
          let td = document.createElement("td");
          td.id = field + "_" + el.id;
          td.headers = field;
          td.innerHTML = el.dataJson[field];
          tr.appendChild(td);
        }
      });
      
      // carga las acciones indicadas
      if(el.action){
        let td = document.createElement("td");
        td.align = "center";
        if(el.action.update){
          let btnEditar = document.createElement('button');
          btnEditar.id = "editar_" + el.id;
          btnEditar.type = "button";
          btnEditar.style.display = "inline";
          btnEditar.className = "button-table btn-azul";
          let a = document.createElement('a'); 
          a.href = el.action.update;
          a.style.color = "inherit";
          a.innerHTML = "<i class='fa fa-pencil' aria-hidden='true'></i>";
          btnEditar.appendChild(a);
          btnEditar.onclick = function(){
            a.click()
          };
          td.appendChild(btnEditar);
          tr.appendChild(td);
        }
        if(el.action.delete){
          // Se crea formulario con metodo POST (es lo que deja mandar laravel)
          let form = document.createElement("form");
          form.id = "form_" + el.id;
          form.method = "POST";
          form.action = el.action.delete;
          form.style.display = "inline";
          
          // agrego el csrf token al formulario
          let hidden = document.createElement("input");
          hidden.type = "hidden";
          hidden.name = "_token";
          hidden.value = csrf_token;
          form.appendChild(hidden);

          // agrego el method delete al formulario
          let method = document.createElement("input");
          method.type = "hidden";
          method.name = "_method";
          method.value = "DELETE";
          form.appendChild(method);

          // agrego el boton delete al formulario
          let bntEliminar = document.createElement('button');
          bntEliminar.id = "eliminar_" + el.id;
          bntEliminar.type = "button";
          bntEliminar.style.display = "inline";
          bntEliminar.className = "button-table btn-rojo";
          bntEliminar.addEventListener("click", function(){
            modal('eliminar',{ title: 'Eliminar!!!',
            width: 400,
            height: 25,
            content: 'Seguro desea eliminar?'},
            ['Aceptar', function(){
              form.submit();
            }],
            ['Cancelar',function(){
               console.log('Cancelar');
            }]);
          });
          bntEliminar.innerHTML = "<i class='fa fa-trash-o' aria-hidden='true'></i>";
          form.appendChild(bntEliminar);
          
          td.appendChild(form);
          tr.appendChild(td);
        }
        if(el.action.js){
          let btnJs = document.createElement('button');
          btnJs.id = "js_" + el.id;
          btnJs.type = "button";
          btnJs.style.display = "inline";
          btnJs.className = "button-table btn-azul";
          btnJs.addEventListener("click", function(){
            el.action.content()
              .then(content => {
                modal('volver',{ title: 'Detalles de factura',
                width: null,
                height: null,
                content: content},
                [ 'Volver', function(){
                  console.log('volver')
                }]);
              });            
          });
          btnJs.innerHTML = "<i class='fa fa-eye' aria-hidden='true'></i>";
          td.appendChild(btnJs);
          tr.appendChild(td);
        }
      }
      tbody.appendChild(tr); 
    }

  }
}

function agregarPaginas(num, inicio, numPaginasF, pagAnt, pagSig){
  var paginacion = document.getElementById("paginacion");
  paginacion.align = "center";
  paginacion.innerHTML = "";
  
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
  
  // se definen las paginas a mostrar
  var pagDesde, pagHasta;
  if(inicio == 0){
    pagDesde = inicio;
    pagHasta = inicio + 2;
  }else if(inicio == (numPaginasF-1)){
    pagDesde = inicio - 2;
    pagHasta = inicio;
  }else{
    pagDesde = inicio - 1;
    pagHasta = inicio + 1;
  }

  if(pagDesde < 0){
    pagDesde = 0;
  }
  if(pagHasta > (numPaginasF-1)){
    pagHasta = (numPaginasF-1);
  }

  //agrego las páginas con el número de página y sus correspondientes enlaces
  for (i = pagDesde;i <= pagHasta;i++){
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

function modal(id, data, ok, cancel) {
  data=data || {};
  id="modal-"+id;
  // Si no existe lo crea
  if (document.getElementById(id)==null) {
    var d=document.createElement("div");
    d.className="modal";
    d.id=id;
    var p=document.createElement("div");
    p.className="modal-panel";
    var t=document.createElement("div");
    t.className="modal-title";
    var cl=document.createElement("div");
    cl.className="modal-close";
    cl.innerHTML='&times;';
    cl.addEventListener('click',function() {
      var dTop=this.parentNode.parentNode;
      dTop.classList.remove("modal-visible");
      dTop.querySelector(".modal-panel .modal-content").innerHTML='';
    });
    var ct=document.createElement("div");
    ct.className="modal-content";
    var f=document.createElement("div");
    f.className="modal-footer";
    p.appendChild(t);p.appendChild(cl);p.appendChild(ct);p.appendChild(f);
    d.appendChild(p);
    document.body.appendChild(d);
  }
  
  // recupero el modal y sos elementos
  var mod=document.getElementById(id),
  p=mod.querySelector(".modal-panel"),
  t=mod.querySelector(".modal-panel .modal-title"),
  ct=mod.querySelector(".modal-panel .modal-content"),
  f=mod.querySelector(".modal-panel .modal-footer");
  
  // carga la informacion en los distintos elementos
  t.innerHTML=data.title || '';
  ct.innerHTML=data.content || '';
  f.innerHTML='';
  
  p.style.maxWidth= 'auto'; //maxWidth default
  p.style.maxHeight= 'auto'; //maxHeight default
  if (!isNaN(data.width)) p.style.maxWidth=data.width+'px';
  if (!isNaN(data.height)) p.style.maxHeight=data.height+'vh';
    
  // verifico si tiene boton cancelar; si tiene agrego el boton al modal
  if (cancel && cancel.length>1) {
    var bCancel=document.createElement("button");
    bCancel.className="modal-action";
    // asigna el nombre al boton
    bCancel.innerHTML=cancel[0];
    bCancel.addEventListener('click',function() {
      mod.classList.remove("modal-visible");
      //asocia el metodo pasado por parametro al evento
      cancel[1]();
    });
    f.appendChild(bCancel);
  }
  
  // verifico si tiene boton aceptar; si tiene agrego el boton al modal
  if (ok && ok.length>1) {
    var bOk=document.createElement("button");
    bOk.className="modal-action";
    // asigna el nombre al boton
    bOk.innerHTML=ok[0];
    bOk.addEventListener('click',function() {
      mod.classList.remove("modal-visible");
      //asocia el metodo pasado por parametro al evento
      ok[1]();
    });
    f.appendChild(bOk);
  }
  
  setTimeout(function(){
    mod.classList.add("modal-visible");
  },50);
}

function ordenarTabla(campo, asc) {

    // se resetean fonts de columnas no ordenandas
    table = document.getElementById("customTable");
    headers = table.rows[0].getElementsByTagName("th");
    for (i = 0; i < (headers.length - 1); i++) {
      if(campo != headers[i].id){
        headers[i].childNodes[1].className = "fa fa-sort";
      }
    }

    // se ordena la columna indicada
    if(asc){
      registrosFiltrados.sort(dynamicSort(campo));
    }else{
      registrosFiltrados.sort(dynamicSort(campo)).reverse();
    }

    // se vuelve a generar la tabla
    paginarAndVisualizarRegistros(REGISTROS_POR_PAGINA, PAGINA_INICIAL);
}

function dynamicSort(property) {
  console.log(property.indexOf("precio") );
    var sortOrder = 1;
    var result;
    if(property[0] === "-") {
        sortOrder = -1;
        property = property.substr(1);
    }
    return function (a,b) {
        // verifico si es un precio o el importe para hacer la comparacion correctamente
        if((property.indexOf("precio") > -1) || (property.indexOf("importe") > -1)){
          result = (parseFloat(a.dataJson[property]) < parseFloat(b.dataJson[property])) ? -1 : (parseFloat(a.dataJson[property]) > parseFloat(b.dataJson[property])) ? 1 : 0;
        }else{
          result = (a.dataJson[property] < b.dataJson[property]) ? -1 : (a.dataJson[property] > b.dataJson[property]) ? 1 : 0;
        }
        return result * sortOrder;
    }
}

function jsonToObject(json){
  var obj = JSON.parse(json);
  return obj;
}

function getCsrfToken(){
  var csrf = "";
  var metas = document.getElementsByTagName('meta');
  for (i=0; i<metas.length; i++) {
    if (metas[i].getAttribute("name") == "csrf-token") {
      csrf = metas[i].getAttribute("content");
      break;
    }
 }
 return csrf;
}

function destroyTabla(){
  document.querySelector('div#contenido').innerHTML = '';
}

document.addEventListener("DOMContentLoaded", function () {
  csrf_token = getCsrfToken()
  if(columnas && registros){
    encabezados = jsonToObject(columnas);
    registros = jsonToObject(datos);
    registrosFiltrados = registros;
    construirTabla(encabezados, registros);
    paginarAndVisualizarRegistros(REGISTROS_POR_PAGINA, PAGINA_INICIAL);
  }
});