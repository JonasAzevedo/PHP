/*
  Nome: jFuncoesColorBox.js
  Função: página js com funções para o plugin ColorBox para jQuery
  Data de Criação: 28/02/2011 - 17:21
  Data de Atualização: -
  Desenvolvido por: Jonas
*/


$(document).ready(function(){
    //Examples of how to assign the ColorBox event to elements
	$("a[rel='figuras1']").colorbox();
	$("a[rel='figuras2']").colorbox();
	$("a[rel='figuras3']").colorbox();
	$("a[rel='figuras4']").colorbox();
	$("a[rel='figuras5']").colorbox();
	$("a[rel='figuras6']").colorbox();
	$("a[rel='figuras7']").colorbox();
	$("a[rel='figuras8']").colorbox();
	$("a[rel='figuras9']").colorbox();

 	//Example of preserving a JavaScript event for inline calls.
 	$("#click").click(function(){
      $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
      return false;
    });
});

