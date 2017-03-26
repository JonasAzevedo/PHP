   $(document).ready(function(){

	  $('#conteudo').hide();

      $('a#exibir').click(function(){

		$('#conteudo').show('slow');

   	   });

      $('a#ocultar').click(function(){

   		$('#conteudo').hide('slow');
      })

});
