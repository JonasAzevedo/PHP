/*******************************************************************
********************************************************************
  Nome: jPgComprarProduto.js
  Função: arquivo com funções JavaScript da página pgComprarProduto.php
  Data de Criação: 15/02/2011 - 09:30
  Data de Atualização: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

/*
//function's:
  IniciarAJAX_CompProd() //inicia objeto AJAX
  ValidarInteiro(psValor) //verifica se parâmetro 'psValor' é um número inteiro
  
  AJAX
  ComprarItemProduto(psTipoProduto, pnCdProduto, pnQtde, psTamanho) //cadastra a compra do item do produto
  CarregarComprarItemProduto() //carrega a compra do item do produto. onreadystatechange(ComprarItemProduto)
*/


function IniciarAJAX_CompProd(){
  var xml_http;

  try {
    xml_http = new XMLHttpRequest();
  } catch(ee) {
    try {
      xml_http = new ActiveXObject("Msxml2.XMLHTTP");
    } catch(e) {
      try {
        xml_http = new ActiveXObject("Microsoft.XMLHTTP");
      } catch(E){
        xml_http = false;
      }
    }
  }
  return xml_http;
} //fim - IniciarAJAX_CompProd()


function ValidarInteiro(psValor){
    if(isNaN(parseInt(psValor))){
      return false;
    }
    else{
      if(psValor > 0){
        return true;
      }
      else{
        return false;
      }
    }
} //fim - ValidarInteiro()


function ComprarItemProduto(psTipoProduto, pnCdProduto, pnQtde, psTamanho){
    var bComprar = true;
    if(!(ValidarInteiro(pnQtde))){
      alert("Digite a quantidade de itens.");
      bComprar = false;
    }
    
    if(bComprar){
      if(psTamanho == "#"){
        alert("Informe o tamanho da camiseta.");
        bComprar = false;
      }
    }

    if(bComprar == true){
      oAjaxComprarItem = IniciarAJAX_CompProd();
      if(oAjaxComprarItem){
        oAjaxComprarItem.onreadystatechange = CarregarComprarItemProduto;
        sUrl = "../pgAjaxComprarItemProduto.php?sTipoProduto=" +psTipoProduto+ "&nCdProduto=" +pnCdProduto+ "&nQtde=" +pnQtde + "&sTamanho=" + psTamanho;
        oAjaxComprarItem.open('GET', sUrl, true);
        oAjaxComprarItem.send(null);
      }
      else{
        alert("AJAX não pode ser criado.");
      }
    } //if(bComprar == true)
} //fim - ComprarItemProduto()


function CarregarComprarItemProduto(){
    if(oAjaxComprarItem.readyState == 4){
      if(oAjaxComprarItem.status == 200){
        var oJson = eval("("+oAjaxComprarItem.responseText+")");
        var inseriu_item_pedido = oJson.registro[0].inseriu_item_pedido;
        //if(inseriu_item_pedido == "sem_usuario_logado"){
        //  alert("Login não foi realizado.");
        //}
        if(inseriu_item_pedido == "sim"){
          location.href="../index.php";
        }
      }
    }
} //fim - CarregarComprarItemProduto()
