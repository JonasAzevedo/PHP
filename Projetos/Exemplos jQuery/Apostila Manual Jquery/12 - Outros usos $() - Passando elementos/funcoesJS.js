$(document).ready(function(){
  $("#aLnkFundoVerde").click(function(evento){
    alert('Fundo verde.');
    evento.preventDefault();
    var documento = $(document.body);
    documento.css("background-color", "green");
  });
  
  $("#aLnkFundoAzul").click(function(evento){
    alert('Fundo azul.');
    evento.preventDefault();
    $(document.body).css("background-color", "blue");
  });
  
  $("#aLnkFundoPreto").click(function(evento){
    alert('Fundo preto.');
    evento.preventDefault();
    var documento = $(document.body);
    document.body.css("background-color", "black");
  });
});
