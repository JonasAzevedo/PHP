$(document).ready(function(){
  $("#linkajax").click(function(evento){
    evento.preventDefault();
    $("#destino").load("respostaAJAX.php", {nome: "Jonas", idade: 25}, function(){
      alert('Saiu do método AJAX.');
    });
  });
});
