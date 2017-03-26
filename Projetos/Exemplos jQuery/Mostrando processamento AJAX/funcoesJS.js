$(document).ready(function(){
   $("#lnk").click(function(event){
    event.preventDefault();
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();
    $('#mask').css({'width':maskWidth,'height':maskHeight});
    $('#mask').fadeIn(1000);
    $('#mask').fadeTo("slow",0.8);
   });
   
    $('#mask').click(function () {
      $(this).hide();
    });
   
});
