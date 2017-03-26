/*******************************************************************
********************************************************************
  Nome: jGeral.js
  Função: funções gerais de JavaScript
  Data de Criação: 09/02/2011 - 11:24
  Data de Atualização: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

/*
//function's:
  IniciarAJAX() //inicia objeto AJAX
*/

function IniciarAJAX(){
  var xml_http;

  try {
    xml_http = new XMLHttpRequest();
  } catch(ee) {
    try {
      xml_http = new ActiveXObject("Msxml2.XMLHTTP");
    } catch(e) {
      try {
        xml_http = new ActiveXObject("Microsoft.XMLHTTP");
      } catch(E){
        xml_http = false;
      }
    }
  }
  return xml_http;
} //fim - IniciarAJAX()
