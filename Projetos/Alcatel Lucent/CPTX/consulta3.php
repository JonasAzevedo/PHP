<?php include("funcoes.php");


if(!isset($_GET['ars'])) {
$_GET['ars'] = null;
}

if(!isset($_GET['ccto'])) {
$_GET['ccto'] = '';
}

if(!isset($_GET['data_i'])) {
$_GET['data_i'] = '';
}

if(!isset($_GET['data_f'])) {
$_GET['data_f'] = '';
}

if(!isset($_SESSION['log_tx'])) {
$_SESSION['log_tx'] = null;
}

if(!isset($_GET['dia'])) {
$_GET['dia'] = null;
}
if(!isset($_GET['ano'])) {
$anog = date("Y");
}
else {
$anog = $_GET['ano'];
}

function verpen($filial,$ccto){
$pendencia = ver_pen_at($filial,$ccto);
if($pendencia == true) {
$pendencia = "<span class='ponteiro' onclick='pendencia(\"$filial\",\"$ccto\");'><img alt='O circuito se encontra em alguma pend&ecirc;ncia.' src='imagens/pender.png' width='20px' height='20px'></span>"; //possui pendencia
}
else {
$pendencia = "<img alt='O circuito n&atilde;o est&aacute; em nenhuma pend&ecirc;ncia.' src='imagens/pendok.png' width='20px' height='20px'>";
}

return $pendencia;
}
function verobj($filial,$ccto){
$objectel =  ver_obj($filial,$ccto);
if($objectel == true) {
	$objectel = ver_obj_at($filial,$ccto);

	if($objectel == true) {  //possui erro no objectel
	$objectel = "<span class='ponteiro' onclick='objectel(\"$filial\",\"$ccto\");'><img alt='O circuito possui falha no Objectel.' src='imagens/Objoff.png'></span>";
	}
	else { //Tudo Okay
	$objectel = "<img alt='O circuito se encontra completo a n&iacute;vel de Objectel.' src='imagens/Objon.png' width='20px' height='20px'>";
	}
}
else { //Não existe parecer de objectel par aeste circuito
$objectel = "<span class='ponteiro'><img alt='O circuito n&atilde;o possui nenhum parecer referente ao Objectel.' onclick='objectel(\"$filial\",\"$ccto\");' src='imagens/Objns.png' width='20px' height='20px'></span>";
}
return $objectel;
}

?>


<html>
<head>

<script language="Javascript" type="text/javascript" charset="iso-8859-1">
function deletor(id,filial,mes,n) {

var confirma = confirm("Tem certeza que deseja deletar o circuito "+ filial +" "+ id + "?",500,600);


	if(confirma) {
		if(mes == null) {
		document.location.href= "redirecionar.php?apagar=1&n=" + n; 
		}
		else {
		document.location.href= "redirecionar.php?apagar=1&n=" + n + "&mes=" + mes; 
		}
	}
	else {
	alert("Operacao abordada!");
	}

}

function pendencia(filial,ccto) {

NovaJanela("cpend.php?ccto="+ccto+"&filial="+filial,"Consulta","750","600","yes");

}

function objectel(filial,ccto) {

NovaJanela("cobj.php?ccto="+ccto+"&filial="+filial,"Consulta","750","600","yes");

}


function NovaJanela(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',status=0,toolbar=0,location=0,menubar=0';
	win = window.open(pagina,nome,settings);
}


</script>

<style type="text/css">

.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.style2 {font-size: 13px}
.style3 {font-size: 12px}
.style4 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-style: italic;
}
.style5 {
	font-size: 16px;
	font-family: Arial, Helvetica, sans-serif;
	color: #333333;
	font-weight: bold;
}

.ponteiro {
	cursor: pointer;
}

</style>
</head>
<body>
<?php


	$con = conectar();

	if(!isset($_GET['ano']) && !isset($_GET['dia']) && !isset($_GET['mes'])) {
	$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `tr` = '$_SESSION[log_tx]' ORDER BY `data_e` ASC");
	$lin = mysql_num_rows($query);
	}
	else {
		
		if(!isset($_GET['dia']) && !isset($_GET['mes'])) {
			$lin = 0;
			$cont =0;
			for($h=1;$h<13; $h++) {
				for($z=0; $z<cal_days_in_month(CAL_GREGORIAN, $h, $anog)+1; $z++) {
					if(strlen($z) == 1) {
						$z = "0" . $z;
					}
					if(strlen($h) == 1) {
						$h = "0" . $h;
					}
					$ndata = $_GET['ano'] . "-" . $h . "-" . $z;
					$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `data_e` = '$ndata' and `tr` = '$_SESSION[log_tx]'");
					while($row = mysql_fetch_array($query)) {
						list($ano,$mes,$dia) = explode("-",$row['data_e']);
						$ndata = $dia . " / " . $mes . " / " . $ano;
						$circuito[$cont] = $row['circuito'];
						$velocidade[$cont] = $row['velocidade'];
						$filial[$cont] = $row['filial'];
						$vdata[$cont] = $ndata;
						$nl[$cont] = $row['n'];
						$cont = $cont+1;
					}
					$lin = mysql_num_rows($query) + $lin;
				}
			}
		}
		else {
			if(isset($_GET['mes']) && $_GET['mes'] != 'nada'){
			$ano = $_GET['ano'];
			$lin = 0;
			$cont=0;
				for($z=0; $z<cal_days_in_month(CAL_GREGORIAN, $_GET['mes'], $ano)+1; $z++) {
					if(strlen($z) == 1) {
						$z = "0" . $z;
					}
					$ndata = $_GET['ano'] . "-" . $_GET['mes'] . "-" . $z;
					$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `data_e` = '$ndata' and `tr` = '$_SESSION[log_tx]'");
					$lin = mysql_num_rows($query) + $lin;

					while($row = mysql_fetch_array($query)) {
						list($ano,$mes,$dia) = explode("-",$row['data_e']);
						$ndata = $dia . " / " . $mes . " / " . $ano;
						$circuito[$cont] = $row['circuito'];
						$velocidade[$cont] = $row['velocidade'];
						$filial[$cont] = $row['filial'];
						$vdata[$cont] = $ndata;
						$nl[$cont] = $row['n'];
						$cont = $cont+1;
					}
				}
			}

			else {
			$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `data_e` = '$_GET[dia]' and `tr` = '$_SESSION[log_tx]'");
			$lin = mysql_num_rows($query);
			}
		}
	}

?>
<div align="right"><span class="style4"><strong>Total de resultado(s)</strong>: <?php echo $lin; ?> circuitos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span><br>
  <br>
</div>

<table width="500px" border="0" align="center" class="style1">
<?php

if(isset($_GET['mes']) && $_GET['mes'] != 'nada'){
echo "<tr align='center' height = '50px' valign='middle'><td colspan='5' align='center'><span class='style5'>"; echo num_mes($_GET['mes']) . " de " .  $_GET['ano']; echo "</span></td></tr>";
echo   "<tr align='center' height = '50px' valign='middle'>
	<th width='130px'>Circuito</th>
	<th width='70px'>Vel.</th>
	<th width='100px'>Pend.</th>
	<th width='100px'>Obj.</th>
	<th width='170px'>Data de exec. </strong></th>
	<th width='70px'>Del.</th>
  </tr>";

	for($x=0; $x<$cont; $x++) {


$pendencia = verpen($filial[$x],$circuito[$x]);
$objectel = verobj($filial[$x],$circuito[$x]);



		echo  "<tr align='center'>
				<td><span class='style2'>" . $filial[$x] . " " . $circuito[$x] . "</span></td> 
				<td><span class='style2'>" . $velocidade[$x] . "</span></td>
				<td><span class='style2'>" . $pendencia . "</span></td>
				<td><span class='style2'>" . $objectel . "</span></td>
				<td><span class='style2'>" . $vdata[$x] . "</span></td>
				<td><span class='style2' onClick='deletor(\"$circuito[$x]\",\"$filial[$x]\",\"$_GET[mes]\",\"$nl[$x]\")'><img src='imagens/Xicon.png' width='15px' height='15px'></span></td>
			  </tr>";
	}
}

else {
	if(isset($_GET['dia']) || $_GET['dia'] != ''){
	list($ano,$mes,$dia) = explode("-",$_GET['dia']);
	$databoas = $dia . " / " . $mes . " / " . $ano;
	
	echo "<tr align='center' height = '50px' valign='middle'><td colspan='4' align='center'><span class='style5'>"; echo "$dia de " . num_mes($mes) . " de $ano"; echo "</span></td></tr>";
echo   "<tr align='center' height = '50px' valign='middle'>
	<th width='130px'>Circuito</th>
	<th width='70px'>Vel.</th>
	<th width='100px'>Pend.</th>
	<th width='100px'>Obj.</th>
	<th width='170px'>Data de exec. </strong></th>
	<th width='70px'>Del.</th>
  </tr>";
		while($row = mysql_fetch_array($query)) {
		list($ano,$mes,$dia) = explode("-",$row['data_e']);
		$ndata = $dia . " / " . $mes . " / " . $ano;
$pendencia = verpen($row['filial'],$row['circuito']);
$objectel = verobj($row['filial'],$row['circuito']);

		echo  "<tr align='center'>
				<td><span class='style2'>" . $row['filial'] . " " . $row['circuito'] . "</span></td> 
				<td><span class='style2'>" . $row['velocidade'] . "</span></td>
				<td><span class='style2'>" . $pendencia . "</span></td>
				<td><span class='style2'>" . $objectel . "</span></td>
				<td><span class='style2'>" . $ndata . "</span></td>
				<td><span class='style2' onClick='deletor(\"$row[circuito]\",\"$row[filial]\",null,\"$row[n]\")'><img src='imagens/Xicon.png' width='15px' height='15px'></span></td>
			  </tr>";
		}
	}
	else {
	
	echo "<tr align='center' height = '50px' valign='middle'><td colspan='5' align='center'><span class='style5'>"; if(isset($_GET['ano'])) {
echo "Ano de " . $_GET['ano']; } else { echo "Todos os Circuitos"; } echo "</span></td></tr>";

echo   "<tr align='center' height = '50px' valign='middle'>
	<th width='130px'>Circuito</th>
	<th width='70px'>Vel.</th>
	<th width='100px'>Pend.</th>
	<th width='100px'>Obj.</th>
	<th width='170px'>Data de exec. </strong></th>
	<th width='70px'>Del.</th>
  </tr>";
		if(isset($_GET['ano'])) {
			for($x=0; $x<$cont; $x++) {
$pendencia = verpen($filial[$x],$circuito[$x]);
$objectel = verobj($filial[$x],$circuito[$x]);
		echo  "<tr align='center'>
				<td><span class='style2'>" . $filial[$x] . " " . $circuito[$x] . "</span></td> 
				<td><span class='style2'>" . $velocidade[$x] . "</span></td>
				<td><span class='style2'>" . $pendencia . "</span></td>
				<td><span class='style2'>" . $objectel . "</span></td>
				<td><span class='style2'>" . $vdata[$x] . "</span></td>
				<td><span class='style2' onClick='deletor(\"$circuito[$x]\",\"$filial[$x]\",\"".date("m")."\",\"$nl[$x]\")'><img src='imagens/Xicon.png' width='15px' height='15px'></span></td>
			  </tr>";
			}
	}
	else {
		while($row = mysql_fetch_array($query)) {
$pendencia = verpen($row['filial'],$row['circuito']);
$objectel = verobj($row['filial'],$row['circuito']);
			list($ano,$mes,$dia) = explode("-",$row['data_e']);
			$ndata = $dia . " / " . $mes . " / " . $ano;
			echo  "<tr align='center'>
				<td><span class='style2'>" . $row['filial'] . " " . $row['circuito'] . "</span></td> 
				<td><span class='style2'>" . $row['velocidade'] . "</span></td>
				<td><span class='style2'>" . $pendencia . "</span></td>
				<td><span class='style2'>" . $objectel . "</span></td>
				<td><span class='style2'>" . $ndata . "</span></td>
					<td><span class='style2' style='cursor: pointer;' onClick='deletor(\"$row[circuito]\",\"$row[filial]\",null,\"$row[n]\")'><img src='imagens/Xicon.png' width='15px' height='15px'></span></td>
				  </tr>";
		}
	}
	}
}
?>
</table>

</body>
</html>
