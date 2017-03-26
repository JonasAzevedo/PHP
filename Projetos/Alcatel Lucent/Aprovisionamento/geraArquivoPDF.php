<?php
    require("arquivoPDF.php");
    
    if(isset($_POST['edOpc'])){
      $opc = $_POST['edOpc'];
    }
    else{
      $opc = "";
    }

    if(isset($_POST['ckBxDescricao'])=='true'){
      if(isset($_POST['mmDescricao'])){
        $textDesc = $_POST['mmDescricao'];
      }
      else {
        $textDesc = "";
      }
    }
    else {
      $textDesc = "";
    }


    $data=date("d/m/Y - h:i");
    
    $arq = new arquivoPDF();
    $arq->geraPDF($opc,$textLeg,$textDesc,$data);
?>
