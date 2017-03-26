<?php include("funcoes.php");

if(!isset($_GET['ccto']) || !isset($_GET['filial'])){
echo "Erro circuito não existe.";
exit;
}
else {
$ccto = $_GET['ccto'];
$filial = $_GET['filial'];
}


if(!isset($_SESSION['log_tx'])) {
echo "<script>";
echo "alert(\"Voce precisa se autenticar no sistema para usufruir deste recurso.\");";
echo "document.location.href = 'index.php';";
echo "</script>";
exit;
}

/* Swap Modificada */
function swap(&$valor_1, &$valor_2, &$tr1 , &$tr2, &$com1, &$com2, &$tab1, &$tab2,&$n1,&$n2,&$Pend1,&$Pend2) {
	list($valor_1, $valor_2) = array($valor_2, $valor_1);
	list($tr1, $tr2) = array($tr2, $tr1);
	list($com1, $com2) = array($com2, $com1);
	list($tab1, $tab2) = array($tab2, $tab1);
	list($n1, $n2) = array($n2, $n1);
	list($Pend1, $Pend2) = array($Pend2, $Pend1);
}

function QualCom($int){
	switch($int) {
		case 1: $com = "Coment&aacute;rio"; break;
		case 2: $com = "Objectel"; break;
		case 3: $com = "Pend&ecirc;nciado"; break;
		default: echo "Não foi determinado o código"; exit;
	}
	return $com;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CPTX - Histórico</title>

<script>
var win = null;
function NovaJanela(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',status=0,toolbar=0,location=0,menubar=0';
	window.open(pagina,nome,settings);
}

function pend(fil,ccto) {
NovaJanela("cpend.php?ccto="+ccto+"&filial="+fil, "Pendência", '500' , '500' , "no");
}
function obj(fil,ccto) {
NovaJanela("cobj.php?ccto="+ccto+"&filial="+fil, "Pendência", '500' , '500' , "no");
}

function swap(id) {

document.getElementById(id).checked = true;
	if(id == "Sim") {
		document.getElementById("scur").style.display = 'block';
		document.getElementById("Nao").checked = false;
	}
	if(id == "Nao") {
		document.getElementById("scur").style.display = 'none';
		document.getElementById("Sim").checked = false;
	}


}

function enc(n,filial,ccto) {
	if(this.par.value == '' || this.par.value == null) {
	alert("Voce precisa definir um parecer.");
	return;
	}

	document.encerra.enc.value = this.par.value;
	document.encerra.action = "inserir.php?mod=cpen&n="+n+"&filial="+filial+"&ccto="+ccto;
	document.encerra.submit();

}

</script>
<form id='encerra' name='encerra' method='POST'>
<input type='hidden' id='enc' name='enc'>
</form>
<style type="text/css">
table.tab {
border: none;
}
table.tab th {
font-family:Arial, Helvetica, sans-serif;
font-size:16px;
font-weight: 900;
}

.historico {
font-family:Arial, Helvetica, sans-serif;
font-size:16px;
font-weight:bold;
}
table.tab td tr {
font-family:Arial, Helvetica, sans-serif;
font-size: 12px;
border: none;
}

table.com th {
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	border: solid 1px #000000;
}
table.com td {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	border: solid 1px #000000;
}
.pendencia {
cursor: pointer;
}

</style>

</head>

<body>

    <table align='center' class='tab'><tr height='30px'><th>Pend&ecirc;ncia<?php

$x = 0;



if(verificar_circ($filial,$ccto) == false) {
	echo "Circuito não existe.";
	exit;
}

//Pendencia
if(ver_pen($filial,$ccto) == true) {
	$con = conectar();
	$query = mysql_query("SELECT* FROM `pendencias` WHERE `n_circ` = '$ccto' and `filial` = '$filial' and `status` = 0");
	mysql_close($con);
	while($row = mysql_fetch_array($query)) {
	$Data[$x] = $row['data_e'];
	$Tr[$x] = $row['tr'];
	$Com[$x] = $row['pendencia'];
	$Pend[$x] = $row['relatorio'];
	$Tab[$x] = '3';
	$n[$x] = $row['n'];
	$x++;
	}
	mysql_free_result($query);
}
else {
//este circuito nunca passou por uma pendencia
echo "<span class='pendencia'><img src='imagens/pendok.png' width='20px' height='20px' alt='Este circuito nunca esteve em uma pendência.'></span>";
}

/* a BOLHA! ;-) */
  for ($i = 0; $i < count($Data); $i++) {
    for ($j = $i; $j < count($Data); $j++) {
      if ($Data[$i] > $Data[$j]) {
       swap($Data[$i], $Data[$j], $Tr[$i], $Tr[$j], $Com[$i], $Com[$j], $Tab[$i], $Tab[$j],$n[$i],$n[$j],$Pend[$i],$Pend[$j]);
      }
    }
  }

$Data = array_reverse($Data);
$Pend = array_reverse($Pend);
$Tr = array_reverse($Tr);
$Com = array_reverse($Com);
$Tab = array_reverse($Tab);
$n = array_reverse($n);





?></tr></th></table>
<br>
<br>
<br>
<?

for($i=0; $i<$x; $i++) {
list($ano,$mes,$dia) = explode("-", $Data[$i]);
$dataMostrada = "$dia / $mes / $ano";
$tipo = QualCom($Tab[$i]);

	echo "<table width='376' class='com' align='center'>";
	echo "<tr>";
		echo "<th scope='col'>Dia $dataMostrada - Resolvido: <input type='radio' id='Nao' checked='true' onclick='swap(this.id)'> N&atilde;o <input type='radio' onclick='swap(this.id)' id='Sim'> Sim</th>";
	echo "</tr>";
	echo "<tr>";
		echo "<td height='102'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$Pend[$i].</td>";
	echo "</tr>";
	echo "<tr id='scur' style='display: none' height='70px'><td align='center'>Parecer: <input type='text' id='par' name='par' size='35'><br><br><input type='button' value='Encerrar Pendência' onclick=\"enc('$n[$i]','$filial','$ccto');\"></td></tr>";
	echo "</table>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>&nbsp;</td>";
echo "</tr>";

}
?>

</body>
</html>
