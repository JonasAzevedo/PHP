/*******************************************************************
********************************************************************
  Nome: jQryPgExibirProdutosRelacionados.js
  Fun��o: arquivo com fun��es jQuery da p�gina pgExibirProdutosRelacionados.php
  Data de Cria��o: 21/03/2011 - 21:33
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

function SlideDiv1() {
    var $active = $('#divSlideShow1 a.active');

	$active.addClass('last-active');

	//verifica se existe um pr�ximo objeto na div #divSlideShow1, caso ele n�o exista, retorna para o primeiro
    var $next =  $active.next().length ? $active.next() : $('#divSlideShow1 a:first');
    var total  = $("#divSlideShow1").parent().find("a").length;

	//c�digo que define as transi��es entre as imagens
    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

function SlideDiv2() {
    var $active = $('#divSlideShow2 a.active');

	$active.addClass('last-active');

	//verifica se existe um pr�ximo objeto na div #divSlideShow2, caso ele n�o exista, retorna para o primeiro
    var $next =  $active.next().length ? $active.next() : $('#divSlideShow2 a:first');
//    alert('bloco 2 = ' + $active.next().length);
	//c�digo que define as transi��es entre as imagens
    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

function SlideDiv3() {
    var $active = $('#divSlideShow3 a.active');

	$active.addClass('last-active');

	//verifica se existe um pr�ximo objeto na div #divSlideShow3, caso ele n�o exista, retorna para o primeiro
    var $next =  $active.next().length ? $active.next() : $('#divSlideShow3 a:first');
//    alert('bloco 3 = ' + $active.next().length);
	//c�digo que define as transi��es entre as imagens
    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

$(function() {
    var nTot = $("#divSlideShow1").find("a").size();
    if(nTot > 1){ //s� executa a fun��o se existir figuras para fazer a transi��o
  	  //executa a fun��o a cada 4 segundos
      setInterval( "SlideDiv1()", 4000 );
    }

    var nTot = $("#divSlideShow2").find("a").size();
    if(nTot > 1){
      //executa a fun��o a cada 5 segundos
      setInterval( "SlideDiv2()", 5000 );
    }
    
    var nTot = $("#divSlideShow3").find("a").size();
    if(nTot > 1){
  	  //executa a fun��o a cada 6 segundos
	  setInterval( "SlideDiv3()", 6000 );
    }
});
