/*******************************************************************
********************************************************************
  Nome: jQryPgConteudo.js
  Fun��o: arquivo com fun��es jQuery da p�gina pgConteudo.class.php
  Data de Cria��o: 27/03/2011 - 19:20
  Data de Atualiza��o: -
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
