var window = window || {},
    document = document || {},
    console = console || {};

var stock = {};
var stockFiltrado = {};
window.onload = function(){
  sidenav();
  ajaxCall("GET","productos",generateTable);
}

function generateTable(res){
    stock = JSON.parse(res);
    var table,thead,tbody,th,tr,td;
    var tablehead = ['id','descripcion','estado','codigo','precio costo','precio venta', 'talle', 'stock'];
    var container = document.querySelector('section.main div.container-table');

    table = document.createElement('table');
    thead = document.createElement('thead');
    tbody = document.createElement('tbody');

    table.appendChild(thead);
    table.appendChild(tbody);

    for(let i = 0; i< tablehead.length; i++){
      th = document.createElement('th');
      th.innerHTML = tablehead[i];
      thead.appendChild(th);
    }

    for(let i = 0; i< stock.length;i++){
      tr = document.createElement('tr');
      td = document.createElement('td');
      td.innerHTML = stock[i].id;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stock[i].descripcion;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stock[i].estado;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stock[i].codigo;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stock[i].precio_costo;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stock[i].precio_venta;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stock[i].talle_id;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stock[i].stock;
      tr.appendChild(td);
      tbody.appendChild(tr);
    }


    container.appendChild(table);

}
