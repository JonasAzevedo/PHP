function deletar(codigo,filial,circuito,data,mes,ano){
    var confirma = confirm("Tem certeza que deseja deletar o circuito "+ filial +" "+ circuito + "?",500,600);
    if(confirma) {
      document.location.href= "apagarOS.php?codigo=" + codigo + "&data=" + data + "&mes=" + mes + "&ano=" + ano;
    }
}

function abrirPagina(url) {
  var width = 250;
  var height = 220;
  var left = 400;
  var top = 200;

  window.open(url,'janela', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
}

