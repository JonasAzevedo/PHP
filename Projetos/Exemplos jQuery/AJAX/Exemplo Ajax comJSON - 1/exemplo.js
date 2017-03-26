$(function(){
    $("#form1").submit(function(event){
        event.preventDefault();
        var username = $("#nome").attr("value");
        var userage = $("#idade").attr("value");
        $.post('ajax.php', {nome: username, idade: userage}, function(json){
            $("#form1").fadeOut("slow",function(){
                $('<p></p>', {"id":"para", text: "Seu nome é "+json.nome+" e você tem "+json.idade+" anos."}).css({backgroundColor: "yellow", fontFamily: "sans-serif"}).fadeIn("slow").appendTo('body');
            });
        }, "json");
    });
});

