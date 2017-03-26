<?php

  class funcoes {
  
    function getMesAtual(){
      $mes = date("M");
      switch ($mes){
        case "Jan":
          return "Janeiro";
          break;
        case "Feb":
          return "Fevereiro";
          break;
        case "Mar":
          return "Março";
          break;
        case "Apr":
          return "Abril";
          break;
        case "May":
          return "Maio";
          break;
        case "Jun":
          return "Junho";
          break;
        case "Jul":
          return "Julho";
          break;
        case "Aug":
          return "Agosto";
          break;
        case "Sep":
          return "Setembro";
          break;
        case "Oct":
          return "Outubro";
          break;
        case "Nov":
          return "Novembro";
          break;
        case "Dec":
          return "Dezembro";
          break;
      } //switch
    } //getMesAtual
  } //funcoes
?>
