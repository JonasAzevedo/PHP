$(document).ready(function(){
  $("#aLnkIniciarProcesso").click(function(evento){
    evento.preventDefault();
    
    $("div").each(function(x){
      elemento = $(this);
      if(elemento.html() == "white")
        return true;
      if(elemento.html() == "nada")
        return false;
      elemento.css("color", elemento.html());
    });
  });
});


