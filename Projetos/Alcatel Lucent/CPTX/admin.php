<?php include("funcoes.php");

logout();
$_GET['nome'] = null;

if(!isset($_SESSION['level'])) {
$_SESSION['level'] = null;
}



if($_SESSION['level'] == 2 || $_SESSION['level'] == 3 || $_SESSION['level'] == 1) {
$permitido = true;
}
else { $permitido = false; }



if(!isset($_GET['filial'])) {
$_GET['filial'] = null;
}

if(!isset($_POST['tr'])) {
$_GET['nome'] = null;
}
else {
$_GET['nome'] = $_POST['tr'];
}
if(isset($_POST['emna'])) {
$_GET['nome'] = $_POST['emna'];
}
if(!isset($_GET['filialp'])) {
$_GET['filialp'] = null;
}
if(!isset($_GET['mes']) or $_GET['mes'] == '') {
$mes = date('m');
$_GET['mes'] = $mes;
}
else {
$mes = $_GET['mes'];
}

if($_GET['filial'] == 1 and $_SESSION['level'] == 1){
$permitido = false;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CPTX - Administrativo</title>
<style type="text/css">

a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: none;
	color: #333333;
}
a:active {
	text-decoration: none;
	color: #333333;
}

</style>
<script language="javascript">
var win = null;
function NovaJanela(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars=yes,status=0,toolbar=0,location=0,menubar=0';
	win = window.open(pagina,nome,settings);
}


function fil(tr,mes) {
	document.hid.emna.value = tr;
	document.hid.action = "admin.php?filialp=1&mes="+mes;
	document.hid.submit();

}

function ano(valor) {
	if(valor == '#') {
	document.location.href =  'admin.php';
	}
	else {
	document.location.href = 'admin.php?ano='+valor;
	}
}
function mes(valor) {
	if(valor == '#') {
	document.location.href =  'admin.php?ano='+get1['ano'];
	}
	else {
	document.location.href =  'admin.php?ano='+get1['ano']+'&mes='+valor;
	}
}

function filialmes(mes,nome) {
document.hid2.tr.value = nome;
	if(mes == null) {
	document.hid2.action = 'admin.php?filialp=1';
	document.hid2.mes.value = null;
	}
	else {
	document.hid2.action = 'admin.php?filialp=1&mes='+mes;
	document.hid2.mes.value = mes;
	}
	document.hid2.submit();
}

function getUrlVars()
{

    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
 
    for(var i = 0; i < hashes.length; i++)
    {	
        hash = hashes[i].split('=');
		hash[1] = unescape(hash[1]);
		vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
 
    return vars;
}
var get1 = getUrlVars();


function mres(dia,mes,ano,nome) {


document.hid2.tr.value = nome;
NovaJanela('resultadosnew.php?dia='+dia+'&mes='+mes+'&ano='+ano,'Circuitos','450','450','yes')
}

function filial(dia,mes,ano,nome,filial) {
document.hid2.tr.value = nome;
NovaJanela('resultadosnew.php?filial='+filial+'&dia='+dia+'&mes='+mes+'&ano='+ano,'Circuitos','450','450','yes');

}

function NovaJanelaf(filial,mes,ano){
NovaJanela('resultadosnew.php?filial='+filial+'&mes='+mes+'&ano='+ano,'Circuitos','450','450','yes');

}

function mfil(dia,mes,ano,filial) {

NovaJanela('resultadosnew.php?filial='+filial+'&dia='+dia+'&mes='+mes+'&ano='+ano,'Circuitos','450','450','yes');

}

</script>

<form name='hid2' id='hid2' action='' method='POST' >
<input type='hidden' name='tr' id='tr'>
<input type='hidden' name='mes' id='mes'>
</form>

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

.style21 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
#topo {
	background-color:#FFFFFF;
	top: 0px;

}
.style2 {
	font-size: 14px;
	font-family: Arial, Helvetica, sans-serif;
	color: #333333;
}
.style3 {
	font-size: 16px;
	font-family: Arial, Helvetica, sans-serif;
	color: #333333;
	font-weight: bold;
}

.topheader {
	font-size: 16px;
	font-family: Arial, Helvetica, sans-serif;
	color: #333333;
}

.style5 {font-size: 12}
.topo  {display: block;}
.style4 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }

.negrito {
cursor: pointer; 
color: black; 
font-weight:bold;
}

.azul {
cursor: pointer; 
color: blue;
font-weight:bold;
}

</style>
</head>

<body>










<center>
<table border="0" cellpadding="0" cellspacing="0" width="848">
<!-- fwtable fwsrc="topo_edit_producao.png" fwbase="topo.png" fwstyle="Dreamweaver" fwdocid = "2142344543" fwnested="0" -->
  <tr>
   <td><img src="imagens\spacer.gif" width="11" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="51" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="15" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="85" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="19" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="61" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="18" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="62" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="18" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="55" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="15" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="49" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="245" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="65" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="6" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="65" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="8" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>

  <tr>
   <td colspan="17"><img name="topo_r1_c1" src="imagens\topo_r1_c1.png" width="848" height="52" border="0" id="topo_r1_c1" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="1" height="52" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="3"><img name="topo_r2_c1" src="imagens\topo_r2_c1.png" width="11" height="20" border="0" id="topo_r2_c1" alt="" /></td>
   <td><div align="center" class="style21"><a href="index.php">In�cio</a></div></td>
   <td rowspan="3"><div align="center" class="style21"><img name="topo_r2_c3" src="imagens\topo_r2_c3.png" width="15" height="20" border="0" id="topo_r2_c3" alt="" /></div></td>
   <td><div align="center" class="style21"><a href="ausencia.php">Aus&ecirc;ncias</a></div></td>
   <td rowspan="3"><div align="center" class="style21"><img name="topo_r2_c5" src="imagens\topo_r2_c5.png" width="19" height="20" border="0" id="topo_r2_c5" alt="" /></div></td>
   <td><div align="center" class="style21"><a href="registro.php">Registro</a></div></td>
   <td rowspan="3"><div align="center" class="style21"><img name="topo_r2_c7" src="imagens\topo_r2_c7.png" width="18" height="20" border="0" id="topo_r2_c7" alt="" /></div></td>
   <td><div align="center" class="style21"><a href="consulta.php">Consulta</a></div></td>
   <td rowspan="3"><div align="center" class="style21"><img name="topo_r2_c9" src="imagens\topo_r2_c9.png" width="18" height="20" border="0" id="topo_r2_c9" alt="" /></div></td>
   <td><div align="center" class="style21"><a href="admin.php">Gr�ficos</a></div></td>
   <td rowspan="3"><div align="center" class="style21"><img name="topo_r2_c11" src="imagens\topo_r2_c11.png" width="15" height="20" border="0" id="topo_r2_c11" alt="" /></div></td>
   <td><div align="center" class="style21"><a href="sobre.php">Sobre</a></div></td>
   <td rowspan="3"><img name="topo_r2_c13" src="imagens\topo_r2_c13.png" width="245" height="20" border="0" id="topo_r2_c13" alt="" /></td>
   <td rowspan="2"><a href='conf.php'><img name="topo_r2_c14" src="imagens\topo_r2_c14.png" width="65" height="17" border="0" id="topo_r2_c14" alt="" /></a></td>
   <td rowspan="3"><img name="topo_r2_c15" src="imagens\topo_r2_c15.png" width="6" height="20" border="0" id="topo_r2_c15" alt="" /></td>
   <td rowspan="2"><a href="redirecionar.php?sair=1"><img name="topo_r2_c16" src="imagens\topo_r2_c16.png" width="65" height="17" border="0" id="topo_r2_c16" alt="" /></a></td>
   <td rowspan="3"><img name="topo_r2_c17" src="imagens\topo_r2_c17.png" width="8" height="20" border="0" id="topo_r2_c17" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="1" height="15" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="2"><img name="topo_r3_c2" src="imagens\topo_r3_c2.png" width="51" height="5" border="0" id="topo_r3_c2" alt="" /></td>
   <td rowspan="2"><img name="topo_r3_c4" src="imagens\topo_r3_c4.png" width="85" height="5" border="0" id="topo_r3_c4" alt="" /></td>
   <td rowspan="2"><img name="topo_r3_c6" src="imagens\topo_r3_c6.png" width="61" height="5" border="0" id="topo_r3_c6" alt="" /></td>
   <td rowspan="2"><img name="topo_r3_c8" src="imagens\topo_r3_c8.png" width="62" height="5" border="0" id="topo_r3_c8" alt="" /></td>
   <td rowspan="2"><img name="topo_r3_c10" src="imagens\topo_r3_c10.png" width="55" height="5" border="0" id="topo_r3_c10" alt="" /></td>
   <td rowspan="2"><img name="topo_r3_c12" src="imagens\topo_r3_c12.png" width="49" height="5" border="0" id="topo_r3_c12" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="1" height="2" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img name="topo_r4_c14" src="imagens\topo_r4_c14.png" width="65" height="3" border="0" id="topo_r4_c14" alt="" /></td>
   <td><img name="topo_r4_c16" src="imagens\topo_r4_c16.png" width="65" height="3" border="0" id="topo_r4_c16" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="1" height="3" border="0" alt="" /></td>
  </tr>
</table>


<table width="843" border="0" align="center">
  <tr>
    <td><div align="center"><br><span class="style3">Taxa de Produ��o</span></div></td>
  </tr>
  <tr>
    <td><br />
      <br />
    <table width="467" border="0" align="center" class="style2">
<?php 

if($permitido == true and !($_SESSION['level'] == 1)) {

echo "<tr align='center'>
<td align='left'><div align='right'>Alterar Visualiza��o: </div></td><td align='left'>";
	if($_GET['filial'] == 1) { 
		echo "<a href=\"admin.php?";
			if(isset($_GET['ano'])){
			echo "&ano=$_GET[ano]";
			}			
			if(isset($_GET['mes'])){
			echo "&mes=$_GET[mes]";
			}
	echo "\">Por TR</a>"; 
	}
	else {
		echo "<a href=\"admin.php?filial=1";
			if(isset($_GET['ano'])){
			echo "&ano=$_GET[ano]";
			}			
			if(isset($_GET['mes'])){
			echo "&mes=$_GET[mes]";
			}
		echo "\">Por Filiais</a>";
		}
	 echo "</td>
</tr>";
}

?><tr align='center'>
<td align='left' class='style2'><div align='right'>Gr�ficos: </div></td><td align='left'><span style="cursor: pointer; color: black;" onclick="NovaJanela('grafico.php?tipo=2<?php

if(isset($_GET['mes'])) {
echo "&mes=$_GET[mes]";
}
if(isset($_GET['ano'])) {
echo "&ano=$_GET[ano]";
}

?>','Gr&aacute;fico','1100','550','yes');return false">Ver Gr�ficos</span></td>
</tr>
<?php 

echo "<tr align='center'>
        <td align='left'>";

if($_SESSION['level'] == 4 or $permitido == true) {

$con = conectar();

		$x=0;
		$query = mysql_query("SELECT DISTINCT `data_e` FROM `tabelacptx`");
		if(mysql_num_rows($query) == 0) {
		exit;
		}


		echo "<div align='right'>Anos Disponiveis: </div></td><td align='left'>";

		while ($row3 = mysql_fetch_array($query)){
			list($yeari,$mes,$dia) = explode("-",$row3['data_e']);
			$year[$x] = $yeari;
			$x++;
			}
		mysql_free_result($query);
		if(!isset($year)) {
		exit;
		}
		$year2 = array_unique($year);
		sort($year);
		echo "<select id='ano' name='ano' onchange='ano(this.value);'>\n\n";
		echo "<option value='#'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>";
		foreach ($year2 as $yearu) {
			echo "<option value='$yearu' "; 
			if(isset($_GET['ano'])) {
				if($_GET['ano'] == $yearu) {
				echo "selected='selected'";
				}
			}

			echo ">$yearu</option>\n";
		}
		echo "\n\n</select>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;M�s: ";
		if(!isset($_GET['ano'])) {
				echo "<select id='mes' name='mes' disabled=1>";
				foreach ($year2 as $yearu) {
					echo "<option value='#'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>";
				}
				echo "</select>";
		}
		else {
			$query = mysql_query("SELECT DISTINCT `data_e` FROM `tabelacptx`");
			$x=0;
			while ($row3 = mysql_fetch_array($query)){
			list($yeari,$mes,$dia) = explode("-",$row3['data_e']);
				if($yeari == $_GET['ano']) {
				$meses[$x] = $mes;
				}
			$x++;
			}
			$meses2 = array_unique($meses);
			sort($meses2);
		echo "<select id='mes' name='mes' onchange='mes(this.value)'>";
			echo "<option value='#'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>";
			foreach ($meses2 as $mes) {
				echo "<option value='$mes'";
					if($_GET['mes'] == $mes) {
					echo "selected='selected'";
					}
				echo ">$mes</option>";
			}
		echo "</select>";
		}
}
echo "</span></td>
      </tr>";
	if(!isset($_GET['ano']) or $_GET['ano'] == '') {
	$ano = date('Y');
	$_GET['ano'] = $ano;
	}
	else {
	$ano = $_GET['ano'];
	}

// cabe�alho

$cor = "#000000";
$mousec = "#00FF00";
$mouseb = "#FFFFFF";
$atrasado = " bgcolor = \"#CCCCCC\" ";
$b1 = " style = \"border-right: 1px solid $cor\" ";
$b2 = " style = \" border-right: 1px solid $cor\" ";
$b3 = " style = \"\" ";
$b4 = " style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;' ";
$tam = "4.5%";
$som_mes = 0;

if($permitido != true) {
exit;
}

echo "</table><br><br><div align='center'><span class='style3'>Mostrando: ";
if($_GET['nome'] != null) {
$query3 = mysql_query("SELECT* FROM `cadastro` WHERE `tr` = '$_GET[nome]'");
echo mysql_error();
	while($row = mysql_fetch_array($query3)){
	echo $row['nome'] . " - ";
	}
}
if($_GET['mes'] != null) {
echo num_mes($_GET['mes']);
}
echo "</span></div>
<p/>

//////////////////////////////////////////////FINAL DA TABELA DE PESQUISA\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

<br />
      <table width='100%' border='0' cellpadding='10' cellspacing='0' class='style4'>
      <tr class='topheader'align='center' onMouseOver='this.style.background=\"$mousec\"' onMouseOut='this.style.background=\"#FFFFFF\"'>
        <td width='20%' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>Nome/Dia</td>
        <td width='$tam' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>1</td>
        <td width='$tam' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>2</td>
        <td width='$tam' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>3</td>
        <td width='$tam' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>4</td>
        <td width='$tam' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>5</td>
        <td width='$tam' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>6</td>
        <td width='$tam' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>7</td>
        <td width='$tam' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>8</td>
        <td width='$tam' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>9</td>
        <td width='$tam' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>10</td>
        <td width='$tam' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>11</td>
        <td width='$tam' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>12</td>
        <td width='$tam' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>13</td>
        <td width='$tam' style='border-bottom: 2px solid $cor; border-right: 1px solid $cor;'>14</td>
        <td width='$tam' style='border-bottom: 2px solid $cor;'>15</td>
      </tr>";

if($_SESSION['level'] == 1) {
$query = mysql_query("SELECT DISTINCT * FROM `cadastro` WHERE `tr` = '$_SESSION[log_tx]'");
}
else {
$query = mysql_query("SELECT DISTINCT * FROM `cadastro` WHERE `level` < 3 ORDER BY `nome` ASC");
}
if(!$query) {
echo mysql_error();
exit;
}
$x=0;
while ($row = mysql_fetch_array($query)) {
$tr[$x] = $row['tr'];
$nome[$x] = $row['nome'];
$x++;
}

if($_GET['filial'] == 1 or $_GET['nome'] != null) {
$tr = array("FNS","PAE", "BSA" , "GNA", "CPE", "CBA", "CTA", "PVO", "RBO", "PLT");
$nome = array("FNS","PAE", "BSA" , "GNA", "CPE", "CBA", "CTA", "PVO", "RBO", "PLT");
}

mysql_free_result($query);
if(!isset($_GET['mes'])) {
$mes = date('m');
}
else {
$mes = $_GET['mes'];
}
$n = 0;
$somatorio = array(null,null,null,null,null,null,null,null,null,null);

	foreach ($tr as $terror) {
	//dias

	echo "<tr align='center' onMouseOver='this.style.background=\"$mousec\"' onMouseOut='this.style.background=\"#FFFFFF\"'>";
	echo "<td $b2>";
		if(($_GET['filial'] != 1 and $_GET['nome'] == null) and $_GET['filialp'] != 1) {
			if($_SESSION['level'] == 5) {
				if($_GET['mes'] != null) {
				echo "<span style='cursor: pointer;' onclick=\"fil('$tr[$n]','$_GET[mes]')\">$nome[$n]</span>";
				}
				else {
				echo "<span onclick=\"fil('$tr[$n]','$_GET[mes]')\">$nome[$n]</span>";
				}
			}
		else {
			if($_GET['mes'] != null) {
				echo "<span style='cursor: pointer;' onclick=\"filialmes('$_GET[mes]','$tr[$n]')\">$nome[$n]</span>";
				}
				else {
				echo "<span style='cursor: pointer;' onclick=\"filialmes('null','$tr[$n]')\">$nome[$n]</span>";
				}	
			}
		}
		else {
			if($_GET['filial'] != null){
			echo "<div class='negrito' 
onclick=\"NovaJanelaf('$nome[$n]','$mes','$ano')\">$nome[$n]</div>";
			}
			else {
			echo $nome[$n];
			}
		}
		echo "</td>";

//Primeira Tabela

		for($z = 1; $z < 16; $z++) {
			if(strlen($z) == 1) {
			$z = "0" . $z;
			}
			$string = "SELECT count('circuito') FROM `tabelacptx` WHERE ";
			if($_GET['filial'] == 1) {
			$string = $string . "`filial` = '$terror' AND `data_e` = '$ano-$mes-$z'";
			}
	else {
			if($_GET['nome'] != null) {
			$string = $string . "`filial` = '$terror' AND `tr` = '$_GET[nome]' AND `data_e` = '$ano-$mes-$z'";
			}
			else {
			$string = $string . "`tr` = '$terror' AND `data_e` = '$ano-$mes-$z'";
			}
	}

			$query = mysql_query($string);

			if(!$query) {
			echo mysql_error();
			exit;
			}
			$string = "count('circuito')";
			//pega valor para a coluna
			while ($row2 = mysql_fetch_array($query)) {
			$linha = $row2[$string];
			$somatorio[$n] += $linha;
			$som_mes += $linha;
			}
			mysql_free_result($query);
		echo "<td"; if($z == 15) { echo $b3; } else { echo $b2; } if(($z < date("d")-3 || (int)$mes < date("m")) && $linha == 0) { echo $atrasado; } echo ">";
			//quantidade...
			if($linha == 0 ) {
			echo $linha;
			}
			else {
				if(($_GET['nome'] != null or $_GET['nome'] != '') && $_GET['filialp'] != null) {
				echo "<div class='azul'
onclick=\"filial('$z','$mes','$ano','$_GET[nome]','$terror');\">$linha</div>";
				}
				else {
					if($_GET['filial'] == 1) {
echo "<div class='azul'
onclick=\"mfil('$z','$mes','$ano','$terror')\">$linha</div>";
					}
					else {
echo "<div class='azul' 
onclick=\"mres('$z','$mes','$ano','$terror');return false\">$linha</div>";
					}
				}
			}


		echo "</td>";
		}
	$n++;
	echo "</tr>";
	}


//Prod. Di�ria

echo "<tr align='center' onMouseOver='this.style.background=\"$mousec\"' onMouseOut='this.style.background=\"$mouseb\"'>";
echo "<td style='border-top: $cor 2px solid; border-right: $cor 1px solid;'>Prod. Di�ria</td>";
for($z=1;$z<16;$z++) {
	if(strlen($z) == 1) {
	$z = "0" . $z;
	}
	if($_GET['nome'] != null) {
	$query = mysql_query("SELECT count('circuito') FROM `tabelacptx` WHERE `data_e` = '$ano-$mes-$z' and `tr` = '$_GET[nome]'");
	}
	else {
		if($_SESSION['level'] == 1) {
		$query = mysql_query("SELECT count('circuito') FROM `tabelacptx` WHERE `data_e` = '$ano-$mes-$z' and `tr` = '$_SESSION[log_tx]'");
		}
		else {
		$query = mysql_query("SELECT count('circuito') FROM `tabelacptx` WHERE `data_e` = '$ano-$mes-$z'");
		}	
	}
	if($z==15){
	echo "<td style='border-top: $cor 2px solid;'>";
	}
	else {
	echo "<td style='border-top: $cor 2px solid; border-right: $cor 1px solid;'>";
	}
	echo "<span style='font-weight: bold; font-size: 12px;'>";
		while ($row2 = mysql_fetch_array($query)) {
			echo $row2[$string];
		}
		echo "</span></td>";
}
echo "</tr>";


?>
    </table>

	  <p>&nbsp;</p>
	  <p><br />
	    </p>
	  <table width="100%" border="0" cellpadding="9" cellspacing="0" class="style4">
<tr class="topheader" align="center">
<?php
//Cabe�alho tabela 2!

echo "<td $b4 width='20%'>Nome/Dia</td>";


for($z = 16; $z < cal_days_in_month(CAL_GREGORIAN, $mes, $ano)+1; $z++) {
        echo "<td $b4 width='$tam'>$z</td>";
}

	echo "<td style='border-bottom: 2px solid $cor;' width='$tam'>&Sigma;</td>";
?>
      </tr>

<?php




//Come�o tabela II

mysql_free_result($query);
if(!isset($_GET['mes'])) {
$mes = date('m');
}
else {
$mes = $_GET['mes'];
}
$n = 0;
$ultimo_dia=cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

	foreach ($tr as $terror) {
	//dias
		echo "<tr align='center' onMouseOver='this.style.background=\"$mousec\"' onMouseOut='this.style.background=\"#FFFFFF\"'>";
	echo "<td $b2>";
		if(($_GET['filial'] != 1 and $_GET['nome'] == null) and $_GET['filialp'] != 1) {
			if($_SESSION['level'] == 5) {
				if($_GET['mes'] != null) {
				echo "<span style='cursor: pointer;' onclick=\"fil('$tr[$n]','$_GET[mes]')\">$nome[$n]</span>";
				}
				else {
				echo "<span onclick=\"fil('$tr[$n]','$_GET[mes]')\">$nome[$n]</span>";
				}
			}
		else {
			if($_GET['mes'] != null) {
				echo "<span style='cursor: pointer;' onclick=\"filialmes('$_GET[mes]','$tr[$n]')\">$nome[$n]</span>";
				}
				else {
				echo "<span style='cursor: pointer;' onclick=\"filialmes('null','$tr[$n]')\">$nome[$n]</span>";
				}	
			}
		}
		else {
			if($_GET['filial'] != null){
			echo "<div class='negrito' 
onclick=\"NovaJanelaf('$nome[$n]','$mes','$ano')\">$nome[$n]</div>";
			}
			else {
			echo $nome[$n];
			}
		}
		echo "</td>";
//Fecha primeira coluna.

//Tabela II
		for($z = 16; $z < $ultimo_dia+1; $z++) {
			if(strlen($z) == 1) {
			$z = "0" . $z;
			}
			$string = "SELECT count('circuito') FROM `tabelacptx` WHERE ";
			if($_GET['filial'] == 1) {
			$string = $string . "`filial` = '$terror' AND `data_e` = '$ano-$mes-$z'";
			}
	else {
			if($_GET['nome'] != null) {
			$string = $string . "`filial` = '$terror' AND `tr` = '$_GET[nome]' AND `data_e` = '$ano-$mes-$z'";
			}
			else {
			$string = $string . "`tr` = '$terror' AND `data_e` = '$ano-$mes-$z'";
			}
	}

			$query = mysql_query($string);

			if(!$query) {
			echo mysql_error();
			exit;
			}
			$string = "count('circuito')";
			//pega valor para a coluna
			while ($row2 = mysql_fetch_array($query)) {
			$linha = $row2[$string];
			$somatorio[$n] += $linha;
			$som_mes += $linha;
			}
			mysql_free_result($query);
		echo "<td"; if($z == 14) { echo $b3; } else { echo $b2; } if(($z < date("d")-3 || (int)$mes < date("m")) && $linha == 0) { echo $atrasado; } echo ">";

			if($linha == 0 ) {
			echo $linha;
			}
			else {
				if(($_GET['nome'] != null or $_GET['nome'] != '') && $_GET['filialp'] != null) {
				echo "<div class='azul'
onclick=\"filial('$z','$mes','$ano','$_GET[nome]','$terror');\">$linha</div>";
				}
				else {
					if($_GET['filial'] == 1) {
echo "<div class='azul'
onclick=\"mfil('$z','$mes','$ano','$terror')\">$linha</div>";
					}
					else {
echo "<div class='azul' 
onclick=\"mres('$z','$mes','$ano','$terror');return false\">$linha</div>";
					}
				}
			}


		echo "</td>";
		}
	echo "<td><span style='font-weight: bold; font-size: 12px;'>$somatorio[$n]</span></td>";
	$n++;
	echo "</tr>";
	}


//Prod. Di�ria

echo "<tr align='center' onMouseOver='this.style.background=\"$mousec\"' onMouseOut='this.style.background=\"$mouseb\"'>";
echo "<td style='border-top: $cor 2px solid; border-right: $cor 1px solid;'>Prod. Di�ria</td>";
for($z=16;$z<$ultimo_dia+1;$z++) {
	if(strlen($z) == 1) {
	$z = "0" . $z;
	}
	if($_GET['nome'] != null) {
	$query = mysql_query("SELECT count('circuito') FROM `tabelacptx` WHERE `data_e` = '$ano-$mes-$z' and `tr` = '$_GET[nome]'");
	}
	else {
		if($_SESSION['level'] == 1) {
		$query = mysql_query("SELECT count('circuito') FROM `tabelacptx` WHERE `data_e` = '$ano-$mes-$z' and `tr` = '$_SESSION[log_tx]'");
		}
		else {
		$query = mysql_query("SELECT count('circuito') FROM `tabelacptx` WHERE `data_e` = '$ano-$mes-$z'");
		}	
	}
	echo "<td style='border-top: $cor 2px solid; border-right: $cor 1px solid;'><span style='font-weight: bold; font-size: 12px;'>";
	
	while ($row2 = mysql_fetch_array($query)) {
		echo $row2[$string];
	}
	echo "</span></td>";
}
	echo "<td style='border-top: $cor 2px solid;'><span style='font-weight: bold; font-size: 18px;'>$som_mes</span></td>";
echo "</tr>";


?>
      </table>      <p>&nbsp;</p></td>
  </tr>
</table>
</center>

<form name='hid' action='' method='post' id='hid'>
<input type='hidden' name='emna' id='emna'>
</form>
</body>
</html>
