$(document).ready(function(){
  $("#aLnkAlterarCorParagrafo").click(function(evento){
    evento.preventDefault();
    $("p").each(function(x){
      if(x%2==0){
        $(this).css("background-color", "#eee");
      }else{
        $(this).css("background-color", "#ccc");
      }
    });
  });
});
