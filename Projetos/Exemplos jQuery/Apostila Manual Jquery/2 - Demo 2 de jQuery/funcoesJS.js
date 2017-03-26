$(document).ready(function(){
    alert('página carregada');
    
    $("#camada").click(function(){
      alert('clicou na camada');
    });
    
    //ao posicionar o mouse em cima da div
    $("#camada").mouseover(function(evento){
      $("#mensagem").css("display", "block");
    });
    
    //ao retirar o mouse de cima da div
    $("#camada").mouseleave(function(evento){
      $("#mensagem").css("display", "none");
    });
});
