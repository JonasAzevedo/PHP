<!-- Conulta de Circuitos
       autor: Jonas da Silva Azevedo
       criado em: 08/03/2010 - 10:33
       última modificação:
-->

<?php
    include("menuPrincipal.html");

    require("conexao.php");
    $bd = new conexao("localhost","root","","os_sac");

    function formataData($dataFormatar){
      $dataExp = explode(" ", $dataFormatar);
      $dataData = explode("-", $dataExp[0]);
      $data = $dataData[2] . "/" . $dataData[1] . "/" . $dataData[0] . " " . $dataExp[1];
      return $data;
    }
    
    //pesquisar por circuito
    if($_GET['acao']=="pesquisar"){
      $sql = "SELECT * FROM os o WHERE o.cod_usuario=1 AND o.codigo IN(SELECT cod_os FROM producao)";
      $pesqCirc = $bd->selecionaDados($sql);
      $total = count($pesqCirc);
      if($total == 0){
        ?>
        <script language="JavaScript">
          window.alert("Nenhum circuito encontrado");
        </script>
        <?php
      }
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <link rel="stylesheet" href="./estilos/pgConsulta.css" type="text/css" />
    
    <script language="JavaScript" src="./js/pgConsulta.js">
    </script>
    
    <title>Consulta</title>
  </head>
  
  <body>
    <div class="divisaoDados_1" id="cxDivisaoDados1">
      <p class="titulo">Meus Circuitos</p>
      <br />
      <form name="frmPesquisaCirc" id="frmPesquisaCirc" method="POST" action="#">
        <span class="campoPesquisa">Ano: </span>
          <select name="selAno" id="selAno">
            <option value="#"></option>
            <option value="2010">2010</option>
          </select> &nbsp;
        <span class="campoPesquisa">Mês: </span>
          <select name="selMes" id="selMes">
            <option value="#"></option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select> &nbsp;
        <span class="campoPesquisa">Circuito: </span>
          <select name="selFilialCirc" id="selFilialCirc">
            <option value="#"></option>
            <option value="FNS">FNS</option>
            <option value="PAE">PAE</option>
            <option value="BSA">BSA</option>
            <option value="GNA">GNA</option>
            <option value="CPE">CPE</option>
            <option value="CBA">CBA</option>
            <option value="CTA">CTA</option>
            <option value="PVO">PVO</option>
            <option value="RBO">RBO</option>
            <option value="PLT">PLT</option>
          </select>
          <input type="text" name="edCircuito" id="edCircuito" size="7" maxlength="7" value="" />

        <input type="submit" class="pesquisar" name="edPesquisar" value="Pesquisar" />
      </form>
      
      <?php
      if($total != 0){
        echo "<table name='tblMeuCircuitos' border='1'>";
          echo "<tr>";
            echo "<th>Filial</th>";
            echo "<th>Circuito</th>";
            echo "<th>Velocidade</th>";
            echo "<th>Tipo</th>";
            echo "<th>Data</th>";
          echo "</tr>";
          foreach($pesqCirc as $mostraCirc){
            echo "<tr>";
              echo "<td>" . $mostraCirc->filial . "</td>";
              echo "<td>" . $mostraCirc->circuito . "</td>";
              echo "<td>" . $mostraCirc->velocidade . "</td>";
              echo "<td>" . $mostraCirc->tipo . "</td>";
              echo "<td>" . $mostraCirc->data_executou . "</td>";
            echo "</tr>";
          }
        echo "</table>";
      }
      ?>
      
      <a href="javascript:abrirPagina('legenda.html');">Legenda</a>

      

    </div>
    
    <div class="divisaoDados_2" id="cxDivisaoDados2">


    </div>

  </body>
  
</html>
