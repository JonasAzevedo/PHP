/********** retorna data atual do sistema  ***********/
//uso: suporte as demais funções deste arquivo
//edDataExec
function dataAtual(){
  hoje = new Date();
  dia = hoje.getDate();
  mes = hoje.getMonth();
  ano = hoje.getYear();
  hora = hoje.getHours();
  minutos = hoje.getMinutes();
  segundos = hoje.getSeconds();
  if (dia < 10){
    dia = "0" + dia;
  }
  mes = mes + 1;
  if (mes < 10){
    mes = "0" + mes;
  }
  if (ano < 2000) {
    ano = 1900 + ano;
  }
  return dia + "-" + mes + "-" + ano + " " + hora + ":" + minutos + ":" + segundos;
}

/********** limpa componentes para cadastro de circuito  ***********/
//uso: botao limpar
function limpar(){
    document.getElementById("cbSelFilial").value = "#";
    document.getElementById("edCircuito").value = "";
    document.getElementById("ckBxTipCirc").checked = false;
    document.getElementById("edVelocidade").value = "E1";
    document.getElementById("edVelocidade").disabled = 1;
    document.getElementById("edDataExec").value = dataAtual();
    document.getElementById("mmDescricao").value = "";
    exibeEscondeDadosCircuitoExistente("esconde");
    exibeCamposCircuito(2);
}

/********** exibe ou esconde dados do circuito existente  ***********/
//uso: controle
function exibeEscondeDadosCircuitoExistente(status){
  if(status=="mostra"){
    document.getElementById("cxCircuitoExist").style.display = "";
  }
  if(status=="esconde"){
    document.getElementById("cxCircuitoExist").style.display = "none"; //esconde
  }
}

/********** exibe ou esconde componentes  ***********/
//uso: suporte as demais funções deste arquivo
function exibeCamposCircuito(i){
  var ok = false;
  var filial = document.getElementById("cbSelFilial").value;
  var ccto = document.getElementById("edCircuito").value;
  if((filial != '#')&&(ccto.length == 7)) { //filial e circuito ok
    if(document.getElementById("edDataExec").value != ""){ //data ok
      if(document.getElementById("ckBxTipCirc").checked == true){ //tipo do circuito FE
        if(document.getElementById("edVelocidade").value != '') { //velocidade
          ok = true;
        }
        else{
          ok = false;
        }
      }else{ //tipo do circuito E1
        ok = true;
      }
    }else{
      ok  = false;
    }
  }else{
    ok  = false;
  }

  if(ok==true){
    document.getElementById("cxPendencia1").style.display = "";
    document.getElementById("cxTitCodPend").style.display = "none";
    document.getElementById("cxTitJustPend").style.display = "none";
    document.getElementById("cxCodPend").style.display = "none";
    document.getElementById("cxJustPend").style.display = "none";
    document.getElementById("rdBtnPendenciaNao").checked = true;
    document.getElementById("rdBtnPendenciaSim").checked = false;

    document.getElementById("cxObjectel1").style.display = "";
    document.getElementById("rdBtnObjectelCompleto").checked = true;
    document.getElementById("rdBtnObjectelIncompleto").checked = false;
    document.getElementById("cxObjJust").style.display = "none";
    document.getElementById("cxTitObjJust").style.display = "none";
  }
  else{
    document.getElementById("cxPendencia1").style.display = "none";
    document.getElementById("cxTitCodPend").style.display = "none";
    document.getElementById("cxTitJustPend").style.display = "none";
    document.getElementById("cxCodPend").style.display = "none";
    document.getElementById("cxJustPend").style.display = "none";
    document.getElementById("rdBtnPendenciaNao").checked = false;
    document.getElementById("rdBtnPendenciaSim").checked = false;


    document.getElementById("cxObjectel1").style.display = "none";
    document.getElementById("rdBtnObjectelCompleto").checked = false;
    document.getElementById("rdBtnObjectelIncompleto").checked = false;
    document.getElementById("cxObjJust").style.display = "none";
    document.getElementById("cxTitObjJust").style.display = "none";
  }
  if(i==1){
    exibeEscondeDadosCircuitoExistente("mostra");
  }
  if(i==2){
    exibeEscondeDadosCircuitoExistente("esconde");
  }
}

/********** status inicial da página  ***********/
//uso: onBody do documento
function inicio() {
  if(document.getElementById("ckBxTipCirc").checked == false){
    document.getElementById("edVelocidade").value = "E1";
    document.getElementById("edVelocidade").disabled = 1;
  }
  else{
    document.getElementById("edVelocidade").disabled = 0;
  }
  document.getElementById("edDataExec").disabled = 1;
  document.getElementById("edDataExec").value = dataAtual();
  exibeEscondeDadosCircuitoExistente("esconde");
  exibeCamposCircuito(2);
}

/********** pesquisa se circuito já existe  ***********/
//uso: ao sair do cbSelFilial ou edCircuito
function pesquisaCircuito(){
  document.frmPesqCirc.cad_edPesFilial.value = document.getElementById('cbSelFilial').value;
  document.frmPesqCirc.cad_edPesCircuito.value = document.getElementById('edCircuito').value;
  document.frmPesqCirc.cad_edPesVelocidade.value = document.getElementById('edVelocidade').value;
  if(document.getElementById("ckBxTipCirc").checked == true){
    document.frmPesqCirc.cad_edPesTipoCirc.value = "FE";
  }
  else{
    document.frmPesqCirc.cad_edPesTipoCirc.value = "E1";
  }
  document.frmPesqCirc.cad_edPesDataExecucao.value = document.getElementById('edDataExec').value;
  document.frmPesqCirc.cad_edPesDescricao.value = document.getElementById('mmDescricao').value;

  document.forms['frmPesqCirc'].submit();
}

/********** valida dados do circuito  ***********/
//uso: componentes do circuito
function verificaCircuito(obj){
  var filial = document.getElementById("cbSelFilial").value;
  var ccto = document.getElementById("edCircuito").value;
  if((filial != '#')&&(ccto.length == 7)) {
    if((obj=="cbSelFilial")||(obj=="edCircuito")){ //realiza a pesquia
      pesquisaCircuito();
    }
  }
  exibeCamposCircuito(2);
}

/********** valida velocidade - exibir componentes  ***********/
function verificaVelocidade() {
  if(document.getElementById("ckBxTipCirc").checked == true){
    document.getElementById("edVelocidade").disabled = 0;
    document.getElementById("edVelocidade").value = '';
	document.getElementById("edVelocidade").focus();
  }
  else{
    document.getElementById("edVelocidade").disabled = 1;
    document.getElementById("edVelocidade").value = "E1";
  }
  exibeCamposCircuito(0);
}

/********** valida objectel - exibir componentes  ***********/
function verificaObjectel() {
  if(document.getElementById("rdBtnObjectelCompleto").checked == false) {
    document.getElementById("cxObjJust").style.display = "";
    document.getElementById("cxTitObjJust").style.display = "";
  }
  else{
    document.getElementById("cxObjJust").style.display = "none";
    document.getElementById("cxTitObjJust").style.display = "none";
  }
}

/********** valida pendência - exibir componentes  ***********/
function verificaPendencia() {
  if(document.getElementById("rdBtnPendenciaSim").checked == true) {
    document.getElementById("cxTitCodPend").style.display = "";
    document.getElementById("cxTitJustPend").style.display = "";
    document.getElementById("cxCodPend").style.display = "";
    document.getElementById("cxJustPend").style.display = "";
    document.getElementById("cxObjectel1").style.display = "none";
    document.getElementById("rdBtnObjectelCompleto").checked = false;
    document.getElementById("rdBtnObjectelIncompleto").checked = false;
    document.getElementById("cxObjJust").style.display = "none";
    document.getElementById("cxTitObjJust").style.display = "none";
  }
  else{
    document.getElementById("cxTitCodPend").style.display = "none";
    document.getElementById("cxTitJustPend").style.display = "none";
    document.getElementById("cxCodPend").style.display = "none";
    document.getElementById("cxJustPend").style.display = "none";

    document.getElementById("cxObjectel1").style.display = "";
    document.getElementById("rdBtnObjectelCompleto").checked = true;
    document.getElementById("rdBtnObjectelIncompleto").checked = false;
    document.getElementById("cxObjJust").style.display = "none";
    document.getElementById("cxTitObjJust").style.display = "none";
  }
}


/********** valida dados antes de inserir  ***********/
//uso: botão Inserir
function verificaInserir(){
    var ok = true;
    var okAtua = true;
    var camposCirc = "";
    var filial = document.getElementById("cbSelFilial").value;
    var ccto = document.getElementById("edCircuito").value;

    //inserir novo
    if((filial == "#")||(ccto.length < 7)){
      camposCirc = " Circuito";
    }
    if((document.getElementById("ckBxTipCirc").checked == true)&&(document.getElementById('edVelocidade').value == "")){
      if(camposCirc == ""){
        camposCirc = " Velocidade FE";
      }
      else{
        camposCirc = camposCirc + ", Velocidade FE";
      }
    }
    if(document.getElementById('edDataExec').value == ""){
      if(camposCirc == ""){
        camposCirc = " Data de Execuçao";
      }
      else{
        camposCirc = camposCirc + ", Data de Execução";
      }
    }

    if(camposCirc != ""){
      window.alert("Preencha os campos: " + camposCirc);
      ok = false;
    }

    if((document.getElementById("rdBtnPendenciaSim").checked == true)&&(document.getElementById('mmJustificativaPendencia').value == "")){
      window.alert("Digite uma Justificativa para a Pendência");
      ok = false;
    }
    if((document.getElementById("rdBtnObjectelIncompleto").checked == true)&&(document.getElementById('mmJustificativaObjectel').value == "")){
      window.alert("Digite uma Justificativa para Objectel Incompleto");
      ok = false;
    }
    return ok;
}

/********** importa dados para registro  ***********/
//uso: deve ser realizada antes de inserir
function importaDadosRegistro(){
   document.frmRegistro.cad_edFilial.value = document.getElementById('cbSelFilial').value;
   document.frmRegistro.cad_edCircuito.value = document.getElementById('edCircuito').value;
   document.frmRegistro.cad_edVelocidade.value = document.getElementById('edVelocidade').value;
   if(document.getElementById('ckBxTipCirc').checked == true){
     document.frmRegistro.cad_edTipoCirc.value = "FE";
   }
   else{
     document.frmRegistro.cad_edTipoCirc.value = "E1";
   }
   document.frmRegistro.cad_edData.value = document.getElementById('edDataExec').value;
   if(document.getElementById('rdBtnPendenciaSim').checked == true){
     document.frmRegistro.cad_edFlagPendencia.value = "1";
     document.frmRegistro.cad_edPendencia.value = document.getElementById('selCodPen').value;
     document.frmRegistro.cad_edDescPendencia.value = document.getElementById('mmJustificativaPendencia').value;
   }
   else{
     document.frmRegistro.cad_edFlagPendencia.value = "0";
     document.frmRegistro.cad_edPendencia.value = "";
     document.frmRegistro.cad_edDescPendencia.value = "";
   }

   if(document.getElementById("cxObjectel1").style.display == "none"){
     document.frmRegistro.cad_edFlagObjectel.value = "9"; //objctel nao disponivel
     document.frmRegistro.cad_edStatusObjectel.value = "";
   }
   else{
     if(document.getElementById('rdBtnObjectelCompleto').checked == true){
       document.frmRegistro.cad_edFlagObjectel.value = "0"; //objectel completo
       document.frmRegistro.cad_edStatusObjectel.value = "Completo";
     }
     else{
       document.frmRegistro.cad_edFlagObjectel.value = "1"; //objectel incompleto
       document.frmRegistro.cad_edStatusObjectel.value = "Incompleto";
     }
   }
   document.frmRegistro.cad_edDescObjectel.value = document.getElementById('mmJustificativaObjectel').value;
   document.frmRegistro.cad_edObsCadastroMesmaData.value = "Cadastro data igual";
   document.frmRegistro.cad_edObsFinalizacaoOS.value = "obs. finalizacao da OS";
}


/********** valida antes de inser  ***********/
//uso: verificação final antes de inserir
function validaInserir() {
   if(verificaInserir()){
     importaDadosRegistro();
     document.forms['frmRegistro'].submit();
   }
}
