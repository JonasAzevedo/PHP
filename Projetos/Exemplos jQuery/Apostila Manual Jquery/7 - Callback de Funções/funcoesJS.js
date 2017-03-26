$(document).ready(function(){
  $("#divCallback").click(function(){
    $("#divCallback").fadeOut(1000, function(){
      $("#divCallback").css({'top': 300, 'left':200});
      $("#divCallback").fadeIn(2000);
    });
  });
});
