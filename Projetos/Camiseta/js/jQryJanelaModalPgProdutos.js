/*******************************************************************
********************************************************************
  Nome: jQryJanelaModalPgProdutos.js
  Fun��o: arquivo com fun��es jQuery para cria��o de janela modais da p�gina pgProdutos.php
  Data de Cria��o: 25/03/2011 - 17:22
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

$(document).ready(function() {
    //m�scara
    $("#txtCompProdQtde").numeric();
    //borda arredondadas
    $("#divDescProdutoComprado").corner("wicked");
    $("#divOpcProdutoComprado").corner("tear");

    //clique no bot�o 'comprar produto'
    $('input:button[class=btnComprarItem]').click(function(evt) {
      var id = $(this).attr('id');
      //passando valores para a janela modal de comprar produto
      var name = $(this).attr('name');
      if(name == "btnComprarItem1"){ var n = 1; }
      else if(name == "btnComprarItem2"){ var n = 2; }
      else if(name == "btnComprarItem3"){ var n = 3; }
      else if(name == "btnComprarItem4"){ var n = 4; }
      else if(name == "btnComprarItem5"){ var n = 5; }
      else if(name == "btnComprarItem6"){ var n = 6; }
      else if(name == "btnComprarItem7"){ var n = 7; }
      else if(name == "btnComprarItem8"){ var n = 8; }
      else if(name == "btnComprarItem9"){ var n = 9; }
      var sTexto = $("#edTipoProduto"+n).val() + ' - ' + $("#spnVlrCaracProdNome"+n).text();
      var nCdProduto = $("#edIdProduto"+n).val();
      var sTipoProduto = $("#edTipoProduto"+n).val();
      
      var dValor = "R$" + $("#spnVlrCaracProdValor"+n).text();
      var dDesconto = $("#spnVlrCaracProdDesconto"+n).text();
      if(dDesconto != "0"){
        dValor = dValor + " - Desconto R$" + dDesconto;
      }
      var sImagem = $("#imgFigura"+n).attr("src");
      $("#imgFiguraProdutoComprar").attr("src",sImagem);
      $("#spnTituloComprarProdutoNome").text(sTexto);
      $("#spnTituloComprarProdutoValor").text(dValor);
      $("#edCdProduto").val(nCdProduto);
      $("#edTipoProduto").val(sTipoProduto);

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
