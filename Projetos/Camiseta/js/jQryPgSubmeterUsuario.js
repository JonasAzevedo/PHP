/*******************************************************************
********************************************************************
  Nome: jQryPgSubmeterUsuario.js
  Fun��o: arquivo com fun��es jQuery da p�gina pgSubmeterUsuario.php
  Data de Cria��o: 17/03/2011 - 23:14
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

$(document).ready(function(){
    //efeito de m�scara na p�gina ao estar
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();
    $('#divMaskSubmeterUsuario').css({'width':maskWidth,'height':maskHeight});
    $('#divMaskSubmeterUsuario').fadeIn(0);
    $('#divMaskSubmeterUsuario').fadeTo("slow",0.8);


    //p�gina sempre ter� a div como m�scara
    //$('#divMaskSubmeterUsuario').click(function () {
    //  $(this).hide();
    //});
});
