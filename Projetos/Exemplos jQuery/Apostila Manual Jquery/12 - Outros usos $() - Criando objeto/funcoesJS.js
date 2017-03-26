$(document).ready(function(){
  $("#aLnkCriaObjeto").click(function(evento){
    evento.preventDefault();
    var novosElementos = $("<div class='divTempoExecucao' id='divTempoExecucao'>Elementos que crio em <b>tempo de execucao</b>.<h1>Em execucao...</h1></div>");
    novosElementos.appendTo("body");
    $("#divTempoExecucao").fadeOut(1000, function(){
      $("#divTempoExecucao").css({'top':250, 'left':400});
      $("#divTempoExecucao").fadeIn(2000);
    });
  });
});
