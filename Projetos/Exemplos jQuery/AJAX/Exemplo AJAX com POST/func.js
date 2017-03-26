/*
jQuery.post( url, [data], [callback], [type] )
URL -> A página para qual você quer fazer a requisição (método POST)
[data] ->  dados a ser passado no POST
[callback] -> Função à ser executada quando os dados são carregados com sucesso
[type] -> Tipo de dado à ser retornado pela função de callback  pode ser: “xml”, “html”, “script”, “json”, “jsonp”, ou “text”.
O padrão é string.
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
