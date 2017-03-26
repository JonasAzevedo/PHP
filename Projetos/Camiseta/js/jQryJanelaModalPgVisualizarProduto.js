/*******************************************************************
********************************************************************
  Nome: jQryJanelaModalPgVisualizarProduto.js
  Função: arquivo com funções jQuery para criação de janela modais da página pgVisualizarProduto.php
  Data de Criação: 25/03/2011 - 10:57
  Data de Atualização: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

$(document).ready(function() {
    //clique no botão 'comprar produto'
    $('input:button[name=btnComprarProduto]').click(function(evt) {
      var id = $(this).attr('id');

      var maskHeight = $(document).height();
      var maskWidth = $(window).width();
      var vscroll = (document.all ? document.scrollTop : window.pageYOffset); //pega posição do scroll na vertical

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
      var vscroll = (document.all ? document.scrollTop : window.pageYOffset); //pega posiçao do scroll na vertical

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
