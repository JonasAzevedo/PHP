/*******************************************************************
********************************************************************
  Nome: jQryPgConteudo.js
  Função: arquivo com funções jQuery da página pgConteudo.class.php
  Data de Criação: 27/03/2011 - 19:20
  Data de Atualização: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

$(document).ready(function() {
    //borda arredondada da div de destaque
    $("#divContDestaque").corner("round 8px").parent().css('padding', '8px').corner("round 14px")

    //esconder a div de destaque depois de 3 segundos
    setTimeout(function(){
      $('#divContDestaque').hide();
    } ,3000);

    
    //ao clicar no link de fechar a div de destaque
    $('#aLnkFecharDestaque').click(function(evt){
      evt.preventDefault();
      $('#divContDestaque').hide();
    });
});
