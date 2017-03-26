$(document).ready(function(){
//    $("#form1").fadeIn(1000);
    $("#form1").submit(function(event){
        event.preventDefault();
        var username = $("#nome").attr("value");
        var userage = $("#idade").attr("value");
        $.post('ajax.php', {nome: username, idade: userage}, function(json){
            $("#form1").fadeOut("slow",function(){
                $('<div></div>',
                {"id":"para",
                text: "Seu nome é "+json.nome+" e você tem "+json.idade+" anos."})
                .css({backgroundColor: "yellow", fontFamily: "sans-serif"})
                .fadeIn("slow").appendTo('body');
            });
            alert(json);

//            alert(json.dados[0].nome);
            
            var oJson = eval(json);
            alert(oJson[0].nome);
            alert(oJson[1].nome);
//            alert(oJson.dados[0].nome);
//            alert(oJson.dados[1].nome);

        }, "json");
    });
});
