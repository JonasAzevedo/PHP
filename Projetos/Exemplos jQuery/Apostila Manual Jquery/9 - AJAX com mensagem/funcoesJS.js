$(document).ready(function(){
    $("#linkajax").click(function(evento){
      evento.preventDefault();
      $("#carregando").css("display", "inline");
      $("#destino").load("pagina-lenta.php", function(){
        $("#carregando").css("display", "none");
      });
   });
})
