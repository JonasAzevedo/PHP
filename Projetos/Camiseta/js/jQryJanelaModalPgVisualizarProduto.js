/*******************************************************************
********************************************************************
  Nome: jQryJanelaModalPgVisualizarProduto.js
  Fun��o: arquivo com fun��es jQuery para cria��o de janela modais da p�gina pgVisualizarProduto.php
  Data de Cria��o: 25/03/2011 - 10:57
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

$(document).ready(function() {
    //clique no bot�o 'comprar produto'
    $('input:button[name=btnComprarProduto]').click(function(evt) {
      var id = $(this).attr('id');

      var maskHeight = $(document).height();
      var maskWidth = $(window).width();
      var vscroll = (document.all ? document.scrollTop : window.pageYOffset); //pega posi��o do scroll na vertical

      $('#mask').css({'width':maskWidth,'height':maskHeight});
      $('#mask').fadeIn(1000);
      $('#mask').fadeTo("slow",0.8);

      //get the window height and width
      var winH = $(window).height();
      var winW = $(window).width();

      $(id).css('top',  (winH/2-$(id).height()/2)+vscroll);
      $(id).css('left', winW/2-$(id).width()/2);

      $(id).fadeIn(2000);
    });
    
    //clique nos links 'indique para um amigo' ou 'esqueci minha senha'
    $('a[name=modal]').click(function(e) {
      e.preventDefault();

      var id = $(this).attr('href');
      var maskHeight = $(document).height();
      var maskWidth = $(window).width();
      var vscroll = (document.all ? document.scrollTop : window.pageYOffset); //pega posi�ao do scroll na vertical

      $('#mask').css({'width':maskWidth,'height':maskHeight});
      $('#mask').fadeIn(1000);
      $('#mask').fadeTo("slow",0.8);

      //Get the window height and width
      var winH = $(window).height();
      var winW = $(window).width();

      $(id).css('top',  (winH/2-$(id).height()/2)+vscroll);
      $(id).css('left', winW/2-$(id).width()/2);

      $(id).fadeIn(2000);
    });


    $('.window .close').click(function (e) {
      e.preventDefault();
      $('#mask').hide();
      $('.window').hide();
    });


    $('#mask').click(function () {
      $(this).hide();
      $('.window').hide();
    });
}); //fim - $(document).ready(function()
