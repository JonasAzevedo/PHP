<?php
     session_start();
     require("sessao.php");
     require("conexao.php");
     require("funcoes.php");
     $bd = new conexao("localhost","root","","os_sac");
     $func = new funcoes();
      
     //imprimir no formato correto a data da pesquisa
     function formataDataPesq($dataFormatar){
       $dataExp = explode("-", $dataFormatar);
       $data = $dataExp[2] . "/" . $dataExp[1] . "/" . $dataExp[0];
       return $data;
     }
     
     function formataData($dataFormatar){
       $dataExp = explode(" ", $dataFormatar);
       $dataData = explode("-", $dataExp[0]);
       $data = $dataData[2] . "/" . $dataData[1] . "/" . $dataData[0] . " " . $dataExp[1];
       return $data;
     }
     
     //define qual e a figura da pendencia
     function mostraFiguraPendencia($flagPend){
       if($flagPend == 0){
         return "<img class='imagemPendObj' src='./imagens/legenda/pend_nao.png'>"; //nao tem pendencia
       }
       elseif($flagPend == 1){
         return "<img class='imagemPendObj' src='./imagens/legenda/pend_sim.png'>"; //tem pendencia
       }
     }
     
     //define qual e a figura do objectel
     function mostraFiguraObjectel($flagObj){
       if($flagObj == 0){
         return "<img class='imagemPendObj' src='./imagens/legenda/obj_completo.png'>"; //tem objectel
       }
       elseif($flagObj == 1){
         return "<img class='imagemPendObj' src='./imagens/legenda/obj_incompleto.png'>"; //nao tem objectel
       }
       elseif($flagObj == 9){
         return "<img class='imagemPendObj' src='./imagens/legenda/obj_nao_disp.png'>"; //nao tem objectel
       }
     }
     
     $data = $_GET['data'];
     $mes = $_GET['mes'];
     $ano = $_GET['ano'];
     
     if($data != ""){ //pesquisar por dia
       $sql = "SELECT * FROM os WHERE cod_usuario='" . $_SESSION["codigoUsuario"] . "' ";
       $sql = $sql . "AND CAST(data_executou AS DATE)='". $data . "'";
     }
     else{ //pesquisar por mês e ano
       $datIni;
       $datFin;
       $datIni = $ano . "-" . $mes . "-01";
       $datFin = $ano . "-" . $mes . "-31";
       $sql = "SELECT * FROM os WHERE data_executou BETWEEN '" . $datIni . "' AND '" . $datFin . "'";
     }
     $pesqOS = $bd->selecionaDados($sql);
     $totalOSs = count($pesqOS);
?>
     
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <link rel="stylesheet" href="./estilos/pgMinhasOSs.css" type="text/css" />
    
    <script language="JavaScript" src="./js/pgMinhasOSs.js">
    </script>
  </head>

  <body>
    <?php
     if($data != ""){ //pesquisa foi por dia
       echo "<span class='dataPesq'>Data Pesquisa: " . formataDataPesq($data) . "</span>";
     }
     else{ //pesquisar foi por mês e ano
       echo "<span class='dataPesq'>Mês Pesquisa: " . $func->retornaMes($mes) . "</span>";
     }
     echo "<span class='totalOS'>Total de OS's: " . $totalOSs . "</span>";
     echo "<span class='legenda'><a href='javascript:abrirPagina(\"legenda.html\");'><img class='legenda' src='./imagens/ajuda.jpg'></a></span>";
     echo "<br />";
     if($totalOSs != 0){ //mostrando OS
       echo "<table class='minhasOSs'>";
         echo "<tr>";
         echo "<th>Filial</th>";
         echo "<th>Circuito</th>";
         echo "<th>Veloc.</th>";
         echo "<th>Data</th>";
         echo "<th>Pend.</th>";
         echo "<th>Obj.</th>";
         echo "<th>Deletar</th>";
       echo "</tr>";
       foreach($pesqOS as $mostra){
         echo "<tr>";
           echo "<td>" . $mostra->filial . "</td>";
           echo "<td>" . $mostra->circuito . "</td>";
           echo "<td>" . $mostra->velocidade . "</td>";
           echo "<td>" . formataData($mostra->data_executou) . "</td>";
           echo "<td>" . mostraFiguraPendencia($mostra->flag_pendencia) . "</td>";
           echo "<td>" . mostraFiguraObjectel($mostra->flag_objectel) . "</td>";
           echo "<td>";
             echo "<span class='deletar' onClick='deletar(\"$mostra->codigo\",\"$mostra->filial\",\"$mostra->circuito\",\"$data\",\"$mes\",\"$ano\")'>";
             echo "<img class='imagemDeletar' src='./imagens/funcoes/deletar.png' >";
             echo "</span>";
           echo "</td>";
         echo "</tr>";
       }
     }

     else{//nao encontrou OS
     
     }
    ?>
  </body>
  
</html>
     
     
     
     
     
     
     

