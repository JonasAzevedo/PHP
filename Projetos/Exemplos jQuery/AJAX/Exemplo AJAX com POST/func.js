/*
jQuery.post( url, [data], [callback], [type] )
URL -> A p�gina para qual voc� quer fazer a requisi��o (m�todo POST)
[data] ->  dados a ser passado no POST
[callback] -> Fun��o � ser executada quando os dados s�o carregados com sucesso
[type] -> Tipo de dado � ser retornado pela fun��o de callback  pode ser: �xml�, �html�, �script�, �json�, �jsonp�, ou �text�.
O padr�o � string.
*/

$(document).ready(function(){
 $('#cadastrar').click(function(){
   //pega o valor dos inputs
   var nome = $('#nome').val();
   var idade = $('#idade').val();
   
   //retorno: TEXT
   $.post('cadastrarUser.php', {nomeUser: nome, idadeUser: idade}, function(dataa){
     $('#resultado').text(dataa)
   }); // Fim do POST
 }); // Fim do Click
 

}); // Fim do Document Read
