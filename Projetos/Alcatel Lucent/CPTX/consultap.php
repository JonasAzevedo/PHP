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

.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style2 {
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
<body><br><center><span class='style3'>Hist&oacute;rico</span></center><br><br>

<table width='90%' border='0' align='center' class='style1'>

<?php

$con = conectar();

$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `circuito` = '$_GET[ccto]' and `filial` = '$_GET[filial]'");

ver_mysql($query);
while($row = mysql_fetch_array($query)) {
	$n = $row['n'];
}
mysql_free_result($query);

if(!isset($n)) {
$n=null;
echo "<center><span class='style2'>N&atilde;o foi possivel encontrar este circuito na base de dados.</span></center>";
return;
}

$query = mysql_query("SELECT* FROM `comentarios` WHERE `n_circ` = '$n' ORDER BY `data_c` DESC");
ver_mysql($query);

if(mysql_num_rows($query)==0) {
echo "<tr height='100px'><td align='center'><p><span class='style2'>N&atilde;o h&aacute; coment&aacute;rios para este circuito.</span></p></td></tr>";
}
else {
	while($row = mysql_fetch_array($query)) {

		list($ano,$mes,$dia) = explode("-",$row['data_c']);

		echo "<tr height='30px'><td><p><span class='style2'>$dia / $mes / $ano - " . tr_nome($row['tr']);
		echo "</span></p><p>&nbsp;&nbsp;&nbsp;&nbsp;<span class='style1'>$row[comentario]</span></p><br></td></tr>";
	}
}
mysql_close($con);


?>
</table>

<?php
echo "<form name='form_ic' action='historico.php?mod=inscom&ccto=$_GET[ccto]&filial=$_GET[filial]&consulta=1' method='post'>

<center>
<span class='style1'>Adicionar Coment&aacute;rio: <br><input type = 'text' id='com' name='com' size ='50' maxlength='1000'></span>
</center>
<center><input type='submit'></center>

</form>";
?>
</body>
</html>
