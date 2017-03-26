<?php
 session_start();

 require("sessao.php");
 require("conexao.php");
 require("funcoes.php");
 $bd = new conexao("localhost","root","","os_sac");
 $func = new funcoes();
 
 $ano = date("Y");
 $mes = date("m");

 include("menuPrincipal.html");

 function formataData($dataFormatar){
   $dataExp = explode(" ", $dataFormatar);
   $dataData = explode("-", $dataExp[0]);
   $data = $dataData[2] . "/" . $dataData[1] . "/" . $dataData[0] . " " . $dataExp[1];
   return $data;
 }
 
 //saudação para usuário
 function periodoDia(){
   $hora = date("H");
   if($hora >= 0 && $hora < 12) {
     return "Bom Dia ";
   }
   elseif ($hora > 12 && $hora < 18) {
     echo "Boa Tarde ";
   }
   else{
     echo "Boa Noite ";
   }
 }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <link rel="stylesheet" href="./estilos/pgIndex.css" type="text/css" />
    
    <script language="JavaScript" src="./js/pgIndex.js">
    </script>

    <title>CPTX</title>
  </head>

  <?php echo "<body OnLoad='javascript: mostraMinhasOSs(\"\",\"$mes\",\"$ano\")' >"; ?>
    <!-- saudações -->
    <div class="grupoDadosUsuario" name="grpDadosUsuario" id="grpDadosUsuario">
      <span class="saudacaoUsuario"> <?php echo periodoDia() . $_SESSION['nomeUsuario']; ?> </span>
      <a href="sugestao.php" class="lnkAjuda">Ajuda</a>
      <?php
        $sql = "SELECT COUNT(codigo) AS total FROM log WHERE cod_usuario='" . $_SESSION['codigoUsuario'] . "'";
        $pesqNroAcesso = $bd->selecionaDados($sql);
        $acesso = $pesqNroAcesso[0]->total;
      ?>
      <br>
      <span class="acesso"> Este e o seu Acesso nº: <?php  echo $acesso; ?> </span>
    </div>
    
    <!-- topo do calendário -->
    <div class="grupoCalendarioGrafico" name="grpDadosCalendario" id="grpDadosCalendario">
      <div class="topoCalendario" name="grpDadosTopoCalendario" id="grpDadosTopoCalendario">
        <?php
          echo "<a class='lnkMes' id='lnkOSsMes' name='id='lnkOSsMes' href='minhasOSs.php?data=&mes=" . $mes . "&ano=" . $ano . "' target='frmMinhasOSs'>" . $func->retornaMes($mes) . "</a> - ";
          echo "&nbsp;&nbsp;";
          echo "<img class='iconeGrafico' src='./imagens/grafico/graf_icon.bmp'>";
        ?>
      </div> <!-- grpDadosTopoCalendario -->
    
      <!-- calendário -->
      <table class="calendario">
        <tr align="center" bgcolor="#00CC33" height='30px'>
	      <th>D</th>
	      <th>S</th>
	  	  <th>T</th>
     	  <th>Q</th>
  	  	  <th>Q</th>
	  	  <th>S</th>
          <th>S</th>
        </tr>

        <?php
          $andar = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes, 1, $ano),0);
          if($andar != 0 ) {
            echo "<tr align='center' height='30px'>";
            for($i=0;$i<$andar;$i++) { //imprimindo espaço em branco na primeira linha
		  	  echo "<td>&nbsp;</td>";
            }
          }
		  for($x=1+$andar; $x<cal_days_in_month(CAL_GREGORIAN, $mes, $ano)+1+$andar; $x++){ //imprimindo dias
		    $dia = $x - $andar;
            if(strlen($dia) == 1) {
		      $dia = "0" . $dia;
            }
    	    $data = $ano . "-" . $mes . "-" . $dia;
    	  
            $sql = "SELECT * FROM os WHERE cod_usuario='" . $_SESSION["codigoUsuario"] . "' ";
            $sql = $sql . "AND CAST(data_executou AS DATE)='". $data . "'";
            $pesqOS = $bd->selecionaDados($sql);
            $totalOS_dia = count($pesqOS);
            if($x%7 == 1) {
		      echo "<tr align='center' height='30px'>";
            }
		    echo "<td><span>"; //class='style37'
		    if($totalOS_dia > 0) {
		  	  echo "<div class='diaOS' onClick='javascript: mostraMinhasOSs(\"$data\",\"\",\"\")'>$dia</div>";
            }
  	        else {
		  	  echo $dia;
	  	    }
		    echo "</span></td>";
		    if($x%7 == 0) {
		      echo "</tr>";
		    }
		  }//for
        ?>
      </table>

      <div class="grupoGrafico">
        <img class="graficoAcompUsuario" src="graficoAcompanhamentoUsuario.php">
      </div>

    </div> <!-- grpDadosCalendario -->
    

    <div class="grupoOSs">
    

    
    <?php
      echo "<iframe src='minhasOSs.php?data=" . $data;
       echo "' name='frmMinhasOSs' id='minhasOSs' width='100%' height='100%' frameborder='0' scrolling='auto'></iframe>";
    ?>
    </div>

  </body>

</html>

<!-- Cadastro de Circuitos
       autor: Jonas da Silva Azevedo
       criado em: 08/03/2010 - 10:33
       última modificação:
-->

