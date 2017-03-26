/*******************************************************************
********************************************************************
  Nome: jPgProdutos.js
  Fun��o: arquivo com fun��es JavaScript da p�gina pgProdutos.php
  Data de Cria��o: 09/02/2011 - 11:05
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

/*
//function's:
  ChamarPaginaComprarItemProduto(psTipoProduto, pnCdProduto) //chama procedimentos para comprar produto
  ChamarPaginaVisualizarProduto(psTipoProduto, pnCdProduto) //chama procedimentos para visualizar produto
*/

//chama procedimentos para comprar produto
function ChamarPaginaComprarItemProduto(psTipoProduto, pnCdProduto){
    var sUrl = "./paginas/pgComprarProduto.php?sTipoProduto=" +psTipoProduto+ "&nCdProduto=" +pnCdProduto;
    location.href = sUrl;
} //fim - ChamarPaginaComprarItemProduto()


//chama procedimentos para visualizar produto
function ChamarPaginaVisualizarProduto(psTipoProduto, pnCdProduto){
    var sUrl = "./paginas/pgVisualizarProduto.php?sTipoProduto=" +psTipoProduto+ "&nCdProduto=" +pnCdProduto+ "&sChamou=paginaPrincipal";
    location.href = sUrl;
}
