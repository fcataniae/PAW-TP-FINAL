var window = window || {},
    document = document || {},
    console = console || {};

window.onload = onloadwindow;

function onloadwindow(){
  controls();
  sidenav();
}

function controls(){
  var negocio = document.querySelector('ul.main-nav li.negocio');
  var venta = document.querySelector('ul.main-nav li.venta');
  var inventario = document.querySelector('ul.main-nav li.inventario');
  if(negocio){
    let snegocio = document.querySelector('nav.sidenav.negocio');
    if(snegocio)
      snegocio.classList.add('close');
    negocio.addEventListener('click',sidenavNegocio);
  }
  if(venta){
    let sventa = document.querySelector('nav.sidenav.venta');
    if(sventa)
      sventa.classList.add('close');
    venta.addEventListener('click',sidenavVenta);
  }
  if(inventario){
    let sinventario = document.querySelector('nav.sidenav.inventario');
    if(sinventario)
      sinventario.classList.add('close');
    inventario.addEventListener('click',sidenavInventario);
  }
}
function sidenav(){

 let expands = document.querySelectorAll('nav.sidenav span.expand');
 console.log(expands);
 expands.forEach( expand =>{
   expand.addEventListener('click', function(){
     let sidenavul = document.querySelector('nav.sidenav.open ul.show');
     let sidenav = document.querySelector('nav.sidenav.open.sidenav-200');
     if(!sidenav || !sidenavul){

       sidenavul = document.querySelector('nav.sidenav.open ul');
       sidenav = document.querySelector('nav.sidenav.open');
       sidenavul.classList.add('show');
       sidenav.classList.add('sidenav-200');
       sidenavul.classList.remove('unshow');
     }else{
       sidenavul = document.querySelector('nav.sidenav.open ul');
       sidenav = document.querySelector('nav.sidenav.open');
       sidenavul.classList.add('unshow');
       sidenav.classList.remove('sidenav-200');
       sidenavul.classList.remove('show');
     }
   });
  });
}

function sidenavInventario(){
  let sidenav = document.querySelector('nav.sidenav.inventario.close');
  let main = document.querySelector('.main');
  closeOthers('inventario');

  if(!sidenav){
    sidenav = document.querySelector('nav.sidenav.inventario');
    main.classList.remove('margin-main');
    sidenav.classList.remove('open');
    sidenav.classList.add('close');
  }else{
    sidenav.classList.remove('close');
    sidenav.classList.add('open');
    main.classList.add('margin-main');
  }
}
function sidenavNegocio(){
  let sidenav = document.querySelector('nav.sidenav.negocio.close');
  let main = document.querySelector('.main');
  closeOthers('negocio');

  if(!sidenav){
    main.classList.remove('margin-main');
    sidenav = document.querySelector('nav.sidenav.negocio');
    sidenav.classList.remove('open');
    sidenav.classList.add('close');
  }else{
    main.classList.add('margin-main');
    sidenav.classList.remove('close');
    sidenav.classList.add('open');
  }
}
function sidenavVenta(){
  let sidenav = document.querySelector('nav.sidenav.venta.close');
  let main = document.querySelector('.main');
  closeOthers('venta');
  if(!sidenav){
    sidenav = document.querySelector('nav.sidenav.venta');
    main.classList.remove('margin-main');
    sidenav.classList.remove('open');
    sidenav.classList.add('close');
  }else{
    sidenav.classList.remove('close');
    main.classList.add('margin-main');
    sidenav.classList.add('open');
  }
}

function closeOthers(sidenav){
  let sides = document.querySelectorAll('nav.sidenav.open');
  console.log();
  sides.forEach( s => {
    if(!s.classList.contains(sidenav)){
      s.classList.remove('open');
      s.classList.add('close');
    }
  });
}
