<?php 
include("funcoes.php");

if(!isset($_GET['nome']) or $_GET['nome'] == '') {
$_GET['nome'] = null;
}
if(!isset($_GET['filial']) or $_GET['filial'] == '') {
$_GET['filial'] = null;
}
if(!isset($_GET['dia']) or $_GET['dia'] == '') {
$_GET['dia'] = null;
}
if(!isset($_GET['ano']) or $_GET['ano'] == '') {
$_GET['ano'] = date("Y");
}
exit;
 ?>
<html>
<head>
<style type="text/css">
body{

background-repeat: repeat-y;
background-color: #FFFFFF;
background-position: center;
background-image:url(bg.png);
margin-top: 0;
}

#flutuante {
	position: absolute;
	bottom: 30px;
	width: 90%;
	background-color: #FFFFFF;
}

.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}

#topo {
	background-color:#FFFFFF;
	top: 0px;

}

.style3 {
	font-size: 16px;
	font-family: Arial, Helvetica, sans-serif;
	color: #333333;
	font-weight: bold;
}

.topheader {
	font-size: 16px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #333333;
}

.style5 {font-size: 12}
.topo  {display: block;}
.style4 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }

</style>
</head>
<body>
<table align='center' class='style1' width='100%'>
<tr height='40px'>
<th align='right' width='5%'>&nbsp;</th>
<th width='20%'>Nome</th>
<th width='20%'>Circuito</th>
</tr>
<?php

$con = conectar();
$data_e = "$_GET[ano]-$_GET[mes]-$_GET[dia]";

if($_GET['nome'] != null) {
	if($_GET['filial'] != null) {
	$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `tr` = '$_GET[nome]' and `data_e` = '$data_e' and `filial` = '$_GET[filial]' ORDER BY `filial` ASC");
	}
	else{
	$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `tr` = '$_GET[nome]' and `data_e` = '$data_e' ORDER BY `filial` ASC");
	}
}
else {
	if($_GET['filial'] != null && $_GET['dia'] == null) {

		$diau = cal_days_in_month(CAL_GREGORIAN, $_GET['mes'], $ano)+1;
		$data_ef = "$_GET[ano]-$_GET[mes]-$diau";
		$data_e = "$_GET[ano]-$_GET[mes]-00";
		$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `data_e` > '$data_e' and `data_e` < '$data_ef' and `filial` = '$_GET[filial]'");
	}
	else {
	$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `data_e` = '$data_e' and `filial` = '$_GET[filial]'");
	}
}
$n = 1;
while ($row = mysql_fetch_array($query)) {
$nome = tr_nome($row['tr']);
echo "<tr align='center'>";
echo "<td align='right'>$n - </td>";
echo "<td>$nome</td>";
echo "<td>$row[filial] $row[circuito]</td>";
echo "</tr>";
$n++;

}

mysql_close($con);
?>
</table>
<br><br><center><input type='button' value='Fechar' onclick='window.close()'></center>

</body>
</html>
