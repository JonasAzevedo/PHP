function validaPesquisa(){
    document.forms['frmPesquisar'].submit();
}

function limpar(){
    document.getElementById("cbSelFilial").value = "#";
    document.getElementById("edCircuito").value = "";
    document.getElementById("edVelocidade").value = "";
    document.getElementById("cbSelTipo").value = "#";
    document.getElementById("cbSelPendencia").value = "#";
    document.getElementById("cbSelObjectel").value = "#";
    document.getElementById("edColaborador").value = "";
    document.getElementById("edDataExecInicio").value = "";
    document.getElementById("edDataExecFinal").value = "";
    document.getElementById("edPagina").value = "";
}

function mudaPagina(pg) {
    if(pg>0){
      pg = pg-1;
    }
    document.frmPesquisar.edPagina.value = pg;
    document.forms['frmPesquisar'].submit();
}

