$(document).ready(function(){
  $("#demaior_idade").click(function(){
    //se checkBox est� marcada
    if ($("#demaior_idade").attr("checked")){
      $("#formulariomaiores").css("display", "block");
    }else{
      $("#formulariomaiores").css("display", "none");
    }
  });
});
