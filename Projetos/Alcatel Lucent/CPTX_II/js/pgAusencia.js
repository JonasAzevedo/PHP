/********** limpa componentes para cadastro de circuito  ***********/
//uso: botao limpar
function limpar(){
    document.getElementById("edDataInicio").value = "";
    document.getElementById("edDataFinal").value = "";
    document.getElementById("txtAreJustificativa").value = "";
}

/********** valida antes de inser  ***********/
//uso: verificação final antes de inserir
function validaInserir() {
    var ok = true;
    var dtInicio = document.getElementById("edDataInicio").value;
    var dtFinal = document.getElementById("edDataFinal").value;
    var justificativa = document.getElementById("txtAreJustificativa").value;

    if((dtInicio != "")&&(dtFinal != "")&&(justificativa != "")){
      ok = true;
    }
    else{
      ok = false;
    }

    if(ok == true){
      document.getElementById("cad_edDataInicio").value = document.getElementById("edDataInicio").value;
      document.getElementById("cad_edDataFinal").value = document.getElementById("edDataFinal").value;
      document.getElementById("cad_edJustificativa").value = document.getElementById("txtAreJustificativa").value;
      document.forms['frmCadastrar'].submit();
    }
    else{
      window.alert("Verifique os campos antes de inserir!");
    }
}


function mudaPagina(pg){
    document.getElementById("edPagina").value = pg;
    document.forms['frmMudarPagina'].submit();
}
