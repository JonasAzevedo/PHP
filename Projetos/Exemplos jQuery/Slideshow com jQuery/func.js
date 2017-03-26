function slideSwitch() {
    var $active = $('#slideshow img.active');

	$active.addClass('last-active');

	// verifica se existe um pr�ximo objeto na div #slideshow, caso ele nao exista, retorna para o primeiro
    var $next =  $active.next().length ? $active.next() : $('#slideshow img:first');

	// Codigo que define as transicoes entre as imagens
    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

$(function() {
	//Executa a fun��o a cada 5 segundos
	setInterval( "slideSwitch()", 5000 );
});
