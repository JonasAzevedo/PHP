/*******************************************************************
********************************************************************
  Nome: jPgPesquisarProdutos.js
  Fun��o: arquivo com fun��es JavaScript da p�gina pgPesquisarProdutos.php
  Data de Cria��o: 15/02/2011 - 11:41
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

/*
//function's:
  VerificarTecla(poTeclaPress) //verificar se foi pressionado <enter>, para acionar o bot�o "Pesquisar"
*/

function VerificarTecla(poTeclaPress){
  var sTecla = poTeclaPress.keyCode; //tecla digitada
  if(sTecla == 13){ //enter
    document.getElementById("btnPesquisarProdutos").click();
  }
} //fim - VerificarTecla()
