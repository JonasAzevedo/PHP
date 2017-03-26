$(document).ready(function(){
   $("#ocultar").click(function(event){
    event.preventDefault();
    $("#camadaefeitos").hide("slow");
   });

   $("#mostrar").click(function(event){
    event.preventDefault();
    $("#camadaefeitos").show(3000);
   });
});
