<?php include("funcoes.php");
if(!isset($_GET['ano'])) {
	$_GET['ano'] = date('Y');
	}
 ?>
<html>
<head>
<script>
function fechar() {
window.close();
}

function t_graf(tr,mes,ano) {

	if(tr == 'geral') {
	document.getElementById('imagem').src = 'graf_geral.php?mes='+mes+'&ano='+ano;
	return;
	}
	else {
		if(tr == 'todos') {
		document.getElementById('imagem').src = 'graf_ind_geral.php?mes='+mes+'&ano='+ano;
		return;
		}
		else {
			if(tr == 'prot') {
			document.getElementById('imagem').src = 'graf_prot.php?mes='+mes+'&ano='+ano;
			}
			else {
				document.getElementById('imagem').src = 'graf_ind.php?tr='+tr+'&mes='+mes+'&ano='+ano;
				return;
			}
		}
	}
}
</script>

<style type="text/css">
#flutuante {
position: absolute;
right: 0px;
top: 0px;
width: 200px;
height: 180px;
padding-left: 10px;
border: 2px solid #cccccc;
background-color: #e0e0e0;

}
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	cursor: pointer;
}
</style>
</head>
<body>


<?php

if($_SESSION['level'] == 4) {
$_GET['tipo'] = 1;
}

switch($_GET['tipo']) {

	case 1:
	echo "<img src='graf_geral.php?mes=";
	if(isset($_GET['mes'])) {
	echo $_GET['mes'];
	}
	else {
	echo date('m');
	}
	echo "'>";
	break;

	case 2:
	$cor = array('black','blue','orange','green','yellow','purple','#ffffff','#028456','#028456','#028456');
	if($_SESSION['level'] == 1) {
	echo "<img id='imagem' src='graf_ind_prot.php?mes=";
	}
	else { 
	echo "<div id='flutuante'>\n";
	$con = conectar();
	$query = mysql_query("SELECT DISTINCT `tr`,`nome` FROM `cadastro` WHERE `level` < 3");
	ver_mysql($query);
	mysql_close($con);
	$x = 0;
	echo "<table width='100%'>\n";
	while($row = mysql_fetch_array($query)) {
	echo "<tr class='style1' onclick=\"t_graf('$row[tr]','$_GET[mes]','$_GET[ano]')\">\n\t<td align='right'><span style='color: $cor[$x];'>----</span></td>\n\t<td align='center'>$row[nome]</td>\n</tr>\n";
	$x++;
	}
	echo "<tr class='style1'><td>&nbsp;</td><td align='center'><span class='style1' onclick=\"t_graf('todos','$_GET[mes]','$_GET[ano]')\">Individual(Com todos)</span></td></tr>";
	echo "<tr class='style1'><td align='right'>----</td><td align='center'><span class='style1' onclick=\"t_graf('geral','$_GET[mes]','$_GET[ano]')\">Geral (Numero de OS's)</span></td></tr>";
	echo "</table>\n";
	echo "</div>\n";
	
echo "<img id='imagem' src='graf_ind_geral.php?mes=";
}

	if(isset($_GET['mes'])) {
	echo $_GET['mes'];
	}
	else {
	echo date('m');
	}
	echo "&ano=";
	if(isset($_GET['ano'])) {
	echo $_GET['ano'];
	}
	else {
	echo date('Y');
	}
	echo "'>\n";
	break;

	default:
	break;
}
?> 

<center>
<input type='button' value='fechar' onclick='fechar()'>
</center>
</body>
</html>
