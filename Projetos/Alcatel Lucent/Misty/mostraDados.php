<?php
  /* tela para mostrar dados em uma tabela - Importar
  Jonas da Silva Azevedo
  Criado: 11/03/2010 - 14:18
  Modificado em: 09/04/2010 - 11:30
*/
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","misty");
  
  echo "<html>";
  echo "<head>";
  echo "</head>";
  echo "<body>";
  
  if($_GET['pesquisar']==true){
    $sql = "SELECT c.* FROM circuitos c WHERE c.processo<>0 ";
    $sqlTotal = "SELECT COUNT(c.codigo) AS total FROM circuitos c WHERE c.processo<>0 ";
    
    //dados Objectel
    if($_POST['imp_objID']!=""){
      $sql = $sql . " AND c.ObjectID LIKE '%" . $_POST['imp_objID'] . "%'";
      $sqlTotal = $sqlTotal . " AND c.ObjectID LIKE '%" . $_POST['imp_objID'] . "%'";
    }
    if(($_POST['imp_TipoCircuitoObj']!="")and($_POST['imp_TipoCircuitoObj']!="Todos")){
      $sql = $sql . " AND c.facilityCircuitType = '" . $_POST['imp_TipoCircuitoObj'] . "'";
      $sqlTotal = $sqlTotal . " AND c.facilityCircuitType = '" . $_POST['imp_TipoCircuitoObj'] . "'";
    }
    if($_POST['imp_ID_CircuitoCRM']!=""){
      $sql = $sql . " AND c.identificadorCircuitoCRM LIKE '%" . $_POST['imp_ID_CircuitoCRM'] . "%'";
      $sqlTotal = $sqlTotal . " AND c.identificadorCircuitoCRM LIKE '%" . $_POST['imp_ID_CircuitoCRM'] . "%'";
    }
    if(($_POST['imp_Filial']!="")and($_POST['imp_Filial']!="Todos")){
      $sql = $sql . " AND c.filial = '" . $_POST['imp_Filial'] . "'";
      $sqlTotal = $sqlTotal . " AND c.filial = '" . $_POST['imp_Filial'] . "'";
    }
    if(($_POST['imp_StatusObj']!="")and($_POST['imp_StatusObj']!="Todos")){
      $sql = $sql . " AND c.status = '" . $_POST['imp_StatusObj'] . "'";
      $sqlTotal = $sqlTotal . " AND c.status = '" . $_POST['imp_StatusObj'] . "'";
    }
    //dados SAC
    if(($_POST['imp_StatusSAC']!="")and($_POST['imp_StatusSAC']!="Todos")){
      $sql = $sql . " AND c.statusSAC = '" . $_POST['imp_StatusSAC'] . "'";
      $sqlTotal = $sqlTotal . " AND c.statusSAC = '" . $_POST['imp_StatusSAC'] . "'";
    }
    if(($_POST['imp_TipoCircuitoSAC']!="")and($_POST['imp_TipoCircuitoSAC']!="Todos")){
      $sql = $sql . " AND c.tipoCircuitoSAC = '" . $_POST['imp_TipoCircuitoSAC'] . "'";
      $sqlTotal = $sqlTotal . " AND c.tipoCircuitoSAC = '" . $_POST['imp_TipoCircuitoSAC'] . "'";
    }
    if(($_POST['imp_Velocidade']!="")and($_POST['imp_Velocidade']!="Todos")){
      $sql = $sql . " AND c.velocidadeSAC = '" . $_POST['imp_Velocidade'] . "'";
      $sqlTotal = $sqlTotal . " AND c.velocidadeSAC = '" . $_POST['imp_Velocidade'] . "'";
    }
    //controle
    if($_POST['imp_controle']=="Novos"){
      $sql = $sql . " AND c.processo ='1'";
      $sqlTotal = $sqlTotal . " AND c.processo ='1'";
    }
    else if($_POST['imp_controle']=="Antigos"){
      $sql = $sql . " AND c.processo ='37'";
      $sqlTotal = $sqlTotal . " AND c.processo ='37'";
    }

    $sql = $sql . " ORDER BY c.codigo";
    
    $dadosRes = $bd->selecionaDados($sql);
    $dadosTotal = $bd->selecionaDados($sqlTotal);
    
    if($dadosTotal[0]->total != 0){
      echo "<table id='tblDadosCircuito' border='1' align='center' cellpadding='10' cellpacing='1'>";
        echo "<tr>";
          echo "<th>Object ID</th>";
          echo "<th>Facility Circuit Type</th>";
          echo "<th>Identificador Circuito CRM</th>";
          echo "<th>Status Objectel</th>";
          echo "<th>Velocidade SAC</th>";
          echo "<th>Tipo Circuito SAC</th>";
          echo "<th>Status SAC</th>";
          echo "<th>Filial</th>";
        echo "</tr>";
        
        echo "<form name='mostraCircuitos' method='POST' action='salvaCircuitos.php'>";
          $i = 0;
          foreach($dadosRes as $mostra){
            echo "<tr>";
              echo "<td>" . $mostra->objectID . "</td>";
              echo "<td>" . $mostra->facilityCircuitType . "</td>";
              echo "<td>" . $mostra->identificadorCircuitoCRM . "</td>";
              echo "<td>" . $mostra->status . "</td>";
              echo "<td>" . $mostra->velocidadeSAC . "</td>";
              echo "<td>" . $mostra->tipoCircuitoSAC . "</td>";
              echo "<td>" . $mostra->statusSAC . "</td>";
              echo "<td>" . $mostra->filial . "</td>";
              echo "<input type='hidden' name='ckBxSalva[]' value='" . $i . "' />";
              echo "<input type='hidden' name='edCodigo[]' value='" . $mostra->codigo . "' size='1' />";
              echo "<input type='hidden' name='edProcesso[]' value='" . $mostra->processo . "' />";
              $i++;
            echo "</tr>";
          }
          echo "</table>";
          echo "<center>";
          echo "<br><br>";
          if($_POST['imp_controle']=="Novos"){
            echo "<input type='submit' name='btnSalvar' value='Mover Para Base Antiga' />";
          }
          else if($_POST['imp_controle']=="Antigos"){
            echo "<input type='submit' name='btnSalvar' value='Mover Para Base Nova' />";
          }
          echo "</center>";
        echo "</form>";
        
        echo "<br /><br />";
        echo "<center>";
        echo "Total de Circutos: " . $dadosTotal[0]->total;
        echo "</center>";
    }
    else{
      echo "<center>";
      echo "Nenhum Circuito encontrado!";
      echo "</center>";
    }
  }
  echo "</body>";
  echo "</html>";
?>
