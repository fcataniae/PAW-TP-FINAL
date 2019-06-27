var window = window || {},
    document = document || {},
    console = console || {};

window.onload = function(){
  onloadwindow();
  initWindow();
}

const filtros =  ['id','importe_desde','importe_hasta','fecha_desde','fecha_hasta','empleado_id','cliente_id','forma_pago_id','estado'];

function initWindow(){

  let input = document.querySelector('section.main input.button-clean');
  input.addEventListener('click',doSearch);
}

function doSearch(){
  let arr = [];

  for(let i = 0; i < filtros.length; i++){
    console.log(filtros[i]);
    let value = document.querySelector('input.form-input.minified#'+ filtros[i]).value;
    if(value && value.trim() != ''){
        let param = {
          'query' : filtros[i],
          'value' : value
        };
        arr.push(param);
    }
  }
  if(arr.length > 0){
    ajaxCallWParameters('GET','/in/filter/facturas',arr,null,null);
  }
}
