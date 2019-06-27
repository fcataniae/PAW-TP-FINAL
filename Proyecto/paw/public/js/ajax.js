function ajaxCall(method,url, callback) {
  var req = new XMLHttpRequest();
  req.open(method, url, true);
  req.addEventListener("load", function() {
    if (this.readyState == 4 && this.status == 200) {
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

function ajaxCallWParameters(method, url, params, callback, errorcalback){
  var req = new XMLHttpRequest();
  console.log(params);
  for(let i = 0; i< params.length; i++){
      url +=  ((i==0)?'?':'&')+params[i].query +'='+ params[i].value;
  }
  console.log(url);

  req.open(method, url, true);
  req.addEventListener("load", function() {
    if (this.readyState == 4 && this.status == 200) {
      // Llamada ala función callback pasándole la respuesta
      callback(req.responseText);
    } else {
      errorcallback(req.responseText,req.status);
    }
  });
  req.addEventListener("error", function(){
    console.error("Error de red");
  });
  req.send();
}
