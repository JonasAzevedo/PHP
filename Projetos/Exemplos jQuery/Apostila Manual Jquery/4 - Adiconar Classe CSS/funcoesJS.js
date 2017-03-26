$(document).ready(function(){
   $("a").mouseover(function(event){
     $("#capa").removeClass("classeInicio");
     $("#capa").addClass("classeOutra");
   });

   $("a").mouseout(function(event){
     $("#capa").removeClass("classeOutra");
     $("#capa").addClass("classeInicio");
   });
   

   //usando a classe da div, para função funcionar
   //nas duas div's da mesma classe.
   $(".classeInicio").mouseover(function(event){
     $(this).removeClass("classeInicio");
     $(this).addClass("classeOutra");
   });

   $(".classeInicio").mouseout(function(event){
     $(this).removeClass("classeOutra");
     $(this).addClass("classeInicio");
   });
});


