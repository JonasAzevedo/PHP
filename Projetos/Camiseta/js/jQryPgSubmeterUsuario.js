/*******************************************************************
********************************************************************
  Nome: jQryPgSubmeterUsuario.js
  Função: arquivo com funções jQuery da página pgSubmeterUsuario.php
  Data de Criação: 17/03/2011 - 23:14
  Data de Atualização: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

$(document).ready(function(){
    //efeito de máscara na página ao estar
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();
    $('#divMaskSubmeterUsuario').css({'width':maskWidth,'height':maskHeight});
    $('#divMaskSubmeterUsuario').fadeIn(0);
    $('#divMaskSubmeterUsuario').fadeTo("slow",0.8);


    //página sempre terá a div como máscara
    //$('#divMaskSubmeterUsuario').click(function () {
    //  $(this).hide();
    //});
});
