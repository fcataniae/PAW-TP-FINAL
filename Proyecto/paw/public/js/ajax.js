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

function ajaxCallWParameters(method, url, params, callback, errorcallback){
  var req = new XMLHttpRequest();
  for(let i = 0; i< params.length; i++){
      url +=  ((i==0)?'?':'&')+params[i].query +'='+ params[i].value;
  }

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

function ajaxCallWithParametersAndRequest(method, url, params, request ,callback, errorcallback){
  var req = new XMLHttpRequest();

  if(params !=null){
    for(let i = 0; i< params.length; i++){
        url +=  ((i==0)?'?':'&')+params[i].query +'='+ params[i].value;
    }
  }
  req.open(method, url, true);
  req.addEventListener("load", function() {
    if (this.readyState == 4 && this.status == 200) {
      // Llamada ala función callback pasándole la respuesta
      if(callback != null){
        callback(req.responseText);
      }else{
        console.log("Peticion exitosa");
      }
    } else {
      if(errorcallback != null){
        errorcallback(req.status, req.responseText);
      }else{
        console.error(req.status + " " + req.statusText);
      }
    }
  });
  req.addEventListener("error", function(){
    if(errorcallback != null){
      errorcallback("Error de red");
    }else{
      console.error("Error de red");
    }
  });

  var metas = document.getElementsByTagName('meta');
  for (i=0; i<metas.length; i++) {
    if (metas[i].getAttribute("name") == "csrf-token") {
      req.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
    }
  }

  if(request == null){
    req.send();
  }else{

    req.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
    req.send(JSON.stringify(request));
  }
}

// usado para metodo -> onunload
function ajaxWithFetch(method, url, request){

    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");
    var metas = document.getElementsByTagName('meta');
      for (i=0; i<metas.length; i++) {
        if (metas[i].getAttribute("name") == "csrf-token") {
          myHeaders.append("X-CSRF-Token", metas[i].getAttribute("content"));
        }
    }

    fetch(url, {
      method: method,
      body: JSON.stringify(request),
      headers: myHeaders,
      keepalive: true
    }).catch(error => console.log('Error:', error))
    .then(response => console.log('Success:', response));
}
