<?php
    session_start();
    require("sessao.php");
    require("conexao.php");
    $bd = new conexao("localhost","root","","os_sac");
    
    function formataData($dataFormatar){
      $dataExp = explode(" ", $dataFormatar);
      $dataData = explode("-", $dataExp[0]);
      $data = $dataData[2] . "/" . $dataData[1] . "/" . $dataData[0] . " " . $dataExp[1];
      return $data;
    }

    $filial = $_GET['fil'];
    $colaborador = $_GET['col'];
    $dia = $_GET['dia'];
    $mes = $_GET['mes'];
    $ano = $_GET['ano'];
    $totIDs = 0;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <link rel="stylesheet" href="./estilos/pgMostraIDs.css" type="text/css" />

    <title>OS's</title>
  </head>

  <body>
    <?php
      //CABEÇALHO DAS OS's
      echo "<span class='spnCabecalho'>OS's referentes: ";
      //colaborador
      if($colaborador != ""){
        echo "Colaborador: ";
        if($colaborador != "Prod_Geral"){
          $sqlColaborador = "SELECT nome FROM usuario WHERE codigo='" . $colaborador . "'";
          $nomeColaborador = $bd->selecionaDados($sqlColaborador);
          echo $nomeColaborador[0]->nome;
        }
        else{
          echo "Todos";
        }
        echo "     -     ";
      }
      //filial
      if($filial != ""){
        echo "Filial: ";
        if($filial != "Prod_Geral"){
          echo $filial;
        }
        else{
          echo "Todas";
        }
        echo "     -     ";
      }
      //data
      echo "Data: ";
      if($dia != "0"){
        echo $dia . "/" . $mes . "/" . $ano;
      }
      else{
        echo $mes . "/" . $ano;
      }
      echo "</span>";
      
      //SELECIONANDO DADOS
      //pesquisando por colaborador
      if($colaborador != ""){ //se tem colaborador selecionado
        //montando data
        $data = $ano . "/" . $mes;
        if($dia != "0"){
          $data = $data . "/" . $dia;
          $dataFin = "";
        }
        else{
          $dataIni = $data . "/01";
          $dataFin = $data . "/31";
        }

        //inicio do sql
        $sql = "SELECT o.*,u.nome FROM os o,usuario u ";
        $sql = $sql . "WHERE o.cod_usuario=u.codigo "; //pegar nome do usuário
        //incluindo data
        if($dataFin == ""){
          $sql = $sql . "AND CAST(o.data_executou AS DATE)='" . $data . "' ";
        }
        else{
          $sql = $sql . "AND CAST(o.data_executou AS DATE) BETWEEN '" . $dataIni . "' AND '" . $dataFin . "' ";
        }
        //incluindo colaborador
        if($colaborador != "Prod_Geral"){
          $sql = $sql . "AND o.cod_usuario='" . $colaborador . "' ";
        }
        $sql = $sql . "ORDER BY o.data_executou";
        $resIDs = $bd->selecionaDados($sql);
        $totIDs = count($resIDs);
        if($totIDs != 0){
          echo "<table class='OSs' name='tblIDs' id='tblIDs'>";
            echo "<tr>";
              if($colaborador == "Prod_Geral"){
                echo "<th>Colaborador</th>";
              }
              echo "<th>Filial</th>";
              echo "<th>Circuito</th>";
              echo "<th>Velocidade</th>";
              echo "<th>Tipo</th>";
              echo "<th>Data</th>";
            echo "</tr>";
            foreach($resIDs as $ID){
              echo "<tr>";
                if($colaborador == "Prod_Geral"){
                  echo "<td>" . $ID->nome . "</td>";
                }
                echo "<td>" . $ID->filial . "</td>";
                echo "<td>" . $ID->circuito . "</td>";
                echo "<td>" . $ID->velocidade . "</td>";
                echo "<td>" . $ID->tipo . "</td>";
                echo "<td>" . formataData($ID->data_executou) . "</td>";
              echo "</tr>";
            } //foreach($resIDs as $ID)
          echo "</table>";
        } //if($totIDs != 0)
        else{
          echo "<span class='spnNenhumaOS'>";
          echo "Nenhuma OS encontrado!";
          echo "</span>";
        }
      } //if($colaborador != "")
      
      else{
      //pesquisando por filial
      if($filial != ""){ //se tem filial selecionada
        //montando data
        $data = $ano . "/" . $mes;
        if($dia != "0"){
          $data = $data . "/" . $dia;
          $dataFin = "";
        }
        else{
          $dataIni = $data . "/01";
          $dataFin = $data . "/31";
        }

        //inicio do sql
        $sql = "SELECT o.*,u.nome FROM os o,usuario u ";
        $sql = $sql . "WHERE o.cod_usuario=u.codigo "; //pegar nome do usuário
        //incluindo data
        if($dataFin == ""){
          $sql = $sql . "AND CAST(o.data_executou AS DATE)='" . $data . "' ";
        }
        else{
          $sql = $sql . "AND CAST(o.data_executou AS DATE) BETWEEN '" . $dataIni . "' AND '" . $dataFin . "' ";
        }
        //incluindo filial
        if($filial != "Prod_Geral"){
          $sql = $sql . "AND o.filial='" . $filial . "' ";
        }
        $sql = $sql . "ORDER BY o.data_executou";
        $resIDs = $bd->selecionaDados($sql);
        $totIDs = count($resIDs);
        if($totIDs != 0){
          echo "<table class='OSs' name='tblIDs' id='tblIDs'>";
            echo "<tr>";
              echo "<th>Colaborador</th>";
              echo "<th>Filial</th>";
              echo "<th>Circuito</th>";
              echo "<th>Velocidade</th>";
              echo "<th>Tipo</th>";
              echo "<th>Data</th>";
            echo "</tr>";
            foreach($resIDs as $ID){
              echo "<tr>";
                echo "<td>" . $ID->nome . "</td>";
                echo "<td>" . $ID->filial . "</td>";
                echo "<td>" . $ID->circuito . "</td>";
                echo "<td>" . $ID->velocidade . "</td>";
                echo "<td>" . $ID->tipo . "</td>";
                echo "<td>" . formataData($ID->data_executou) . "</td>";
              echo "</tr>";
            } //foreach($resIDs as $ID)
          echo "</table>";
        } //if($totIDs != 0)
        else{
          echo "<br /><br />";
          echo "<span class='spnNenhumaOS'>";
          echo "Nenhuma OS encontrado!";
          echo "</span>";

        }
      } //if($filial != "")
      } //else
    ?>
    
    <?php
      if(($totIDs != 0)&&($totIDs != "")){
      ?>
      <div class="divInf">
        <span class="spnTotalIDs"> <?php echo "Total de OS's: " . $totIDs; ?> </span>
      </div>
      <?php
      }
      ?>
    <div class="divInf">
      <input type="button" value="Fechar" onclick="window.close();"/>
    </div>

  </body>
  
</html>

