/*******************************************************************
********************************************************************
  Nome: jPgPesquisarProdutos.js
  Função: arquivo com funções JavaScript da página pgPesquisarProdutos.php
  Data de Criação: 15/02/2011 - 11:41
  Data de Atualização: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

/*
//function's:
  VerificarTecla(poTeclaPress) //verificar se foi pressionado <enter>, para acionar o botão "Pesquisar"
*/

function VerificarTecla(poTeclaPress){
  var sTecla = poTeclaPress.keyCode; //tecla digitada
  if(sTecla == 13){ //enter
    document.getElementById("btnPesquisarProdutos").click();
  }
} //fim - VerificarTecla()
