<?php include("funcoes.php"); ?><html>
<head>
<script>
function del_com(id,ccto,filial) {

var confirma = confirm("Tem certeza que deseja deletar este comentário ? ");


	if(confirma) {
		document.location.href= "redirecionar.php?apagar=2&n="+id+"&ccto="+ccto+"&filial="+filial; 
		//document.location.href= "redirecionar.php?apagar=1&filial=" + filial + "&circ=" + id; 
	}

}

</script>
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
	font-size: 13px;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.rodape {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	display:none;
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
.topo  {display: block;}
.style4 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }

</style>
</head>
<body>
<table width='90%' border='0' align='center' class='style1'>

<?php

$con = conectar();

$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `circuito` = '$_GET[ccto]' and `filial` = '$_GET[filial]'");

ver_mysql($query);
while($row = mysql_fetch_array($query)) {
	$n = $row['n'];
}
mysql_free_result($query);

$query = mysql_query("SELECT* FROM `comentarios` WHERE `n_circ` = '$_GET[ccto]' and `filial` = '$_GET[filial]' ORDER BY `data_c` DESC");
ver_mysql($query);

if(mysql_num_rows($query)==0) {
echo "<tr height='100px'><td align='center'><p><span class='style2'>N&atilde;o h&aacute; coment&aacute;rios para este circuito.</span></p></td></tr>";
}
else {
	while($row = mysql_fetch_array($query)) {

		list($ano,$mes,$dia) = explode("-",$row['data_c']);

		echo "<tr height='30px'><td><p><span class='style2'><b>$dia / $mes / $ano - " . tr_nome($row['tr']) . ":</b>";
		echo "</span></p><p>&nbsp;&nbsp;&nbsp;&nbsp;<span class='style1'>$row[comentario]</span></p><br></td></tr>";
	}
}
mysql_close($con);


?>
</table>
</body>
</html>
