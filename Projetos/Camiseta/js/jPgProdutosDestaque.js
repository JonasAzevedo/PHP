/*******************************************************************
********************************************************************
  Nome: jPgProdutosDestaque.js
  Função: arquivo com funções JavaScript da página pgProdutosDestaque.php
  Data de Criação: 22/02/2011 - 21:33
  Data de Atualização: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

/*
//function's:
  $(document).ready(function(){  //inicia o plugin Coin-Slider
*/

$(document).ready(function(){
  var w = $("#coin-slider").width();
  $('#coin-slider').coinslider({ width: w, height: 80, navigation: true, delay: 3000 });
});

