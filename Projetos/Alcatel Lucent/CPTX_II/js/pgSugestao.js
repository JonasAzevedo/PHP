function limpar(){
    document.getElementById("cbSelTipo").value = "#";
    document.getElementById("txtAreaSugestao").value = "";
}


function validaInserir() {
   if(verificaInserir()){
     importaDadosRegistro();
     document.forms['frmRegistro'].submit();
   }
}

function validaInserir(){
    var tipo = document.getElementById("cbSelTipo").value;
    var desc = document.getElementById("txtAreaDescricao").value;
    var campos = "";

    //inserir novo
    if(tipo == "#"){
      campos = "tipo";
    }
    if(desc == ""){
      if(campos == ""){
        campos = "descrição";
      }
      else{
        campos = campos + ", descrição";
      }
    }

    if(campos != ""){
      window.alert("Preencha os campos: " + campos);
    }
    else{
      document.forms['frmAjuda'].submit();
    }
}

