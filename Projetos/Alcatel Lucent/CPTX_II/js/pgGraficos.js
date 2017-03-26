function novaJanela(filial,colaborador,dia,mes,ano){
    var win = null;
    var nome = "ID's";
    LeftPosition = (screen.width) ? (screen.width-700)/2 : 0;
    TopPosition = (screen.height) ? (screen.height-400)/2 : 0;
    settings = 'height=400,width=520,top='+TopPosition+',left='+LeftPosition+',scrollbars=yes,resizable';
    pagina = "mostraIDs.php?fil=" + filial + "&col=" + colaborador + "&dia=" + dia + "&mes=" + mes + "&ano=" + ano;
    win = window.open(pagina,nome,settings);
}

function pessquisarOS(){
  document.forms['frmPesquisa'].submit();
}
