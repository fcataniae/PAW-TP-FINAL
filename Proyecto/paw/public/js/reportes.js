var window = window || {},
    document = document || {},
    console = console || {};


document.addEventListener("DOMContentLoaded", () => {
  filters = filtros;
  filterUrl = '/in/facturas/reportes/filter';
  drawFilters();

  
  async function showDetails(nroFac){
    
    let response = await fetch(`/in/factura/get/detalles/${nroFac}`);
    let detalles = await response.json();
    let table,thead,tbody,tr,td,th;
    const headers = ['producto','codigo','talle','precio','cantidad'];
    table = document.createElement('table');
    table.classList.add('table');
    tbody = document.createElement('tbody');
    thead = document.createElement('thead');
    for(let i = 0; i< headers.length ;i++){
    th = document.createElement('th');
    th.innerHTML = headers[i];
    thead.appendChild(th);
    }
    table.appendChild(thead);
    for(let i = 0; i< detalles.length ;i++){
    tr = document.createElement('tr');
    td = document.createElement('td');
    td.innerHTML = detalles[i].producto;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = detalles[i].codigo;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = detalles[i].talle;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = detalles[i].precio;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = detalles[i].cantidad;
    tr.appendChild(td);
    tbody.appendChild(tr);
    }
    table.appendChild(tbody);
    let container = document.createElement('div');
    container.appendChild(table);
    return container.outerHTML;
  }

  function getDetails(nroFac){
    return () => {
      return showDetails(nroFac);
    }
  }
  
  function addJsHandler(res){
    res.columnas.push({headerName: 'Detalle', field: 'accion', width: '10%'});
    res.registros.forEach(res => {
      nroFac = res.id;
      res['action'] = { js: true, content: getDetails(nroFac) };
    });
  }

  callbackFn = function printTable(res){
    res = JSON.parse(res);
    destroyTabla();
    addJsHandler(res);
    encabezados = res.columnas;
    registrosFiltrados = res.registros;
    registros = res.registros;
    construirTabla(encabezados, registros);
    paginarAndVisualizarRegistros(REGISTROS_POR_PAGINA, PAGINA_INICIAL);
  }

  errorCalbackFn = function showError(res,stat){
    console.log(res);
    console.log(stat);
  }
});


