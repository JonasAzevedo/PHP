/*******************************************************************
********************************************************************
  Nome: jPgSubmeterUsuario.js
  Fun��o: arquivo com fun��es JavaScript da p�gina pgSubmeterUsuario.php
  Data de Cria��o: 18/03/2011 - 09:26
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

/*
//function's:
  MostrarMensagemUsuarioCadastrado() //mostra mensagem na tela que usu�rio foi cadastrado com sucesso
  RedirecionarPagina() //realiza redirecionamento da p�gina

*/

var nCont = 3;

function MostrarMensagemUsuarioCadastrado(){
    document.getElementById("spnMsgSucesso").style.display = 'block';
    document.getElementById("spnMsgSucessoCont").style.display = 'block';
    if((nCont - 1) >= 0){
      nCont = nCont - 1;
      document.getElementById("spnMsgSucessoCont").innerHTML = nCont + ' segundos';
      if(nCont == 0){
        RedirecionarPagina();
      }
      setTimeout('MostrarMensagemUsuarioCadastrado()',1000);
    }
} //fim - MostrarMensagemUsuarioCadastrado()


function RedirecionarPagina(){
    window.location = '../index.php';
} //fim - RedirecionarPagina()
