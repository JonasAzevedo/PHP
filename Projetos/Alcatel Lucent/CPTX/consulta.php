<?php include("funcoes.php");


logout();

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

?>
<html>
<title>CPTX - Consulta</title>
<head>

<!-- European format dd-mm-yyyy -->
<script language="JavaScript" src="calendar\calendar1.js"></script><!-- Date only with year scrolling -->
<!-- American format mm/dd/yyyy -->
<script language="JavaScript" src="calendar\calendar2.js"></script><!-- Date only with year scrolling -->

<script language="JavaScript">

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


function consultar() {
var erro = false;
		if (document.consulta.filial.value == '#' || document.consulta.filial.value == '' || document.consulta.filial.value == null) {
		alert("Escolha uma filial.");
		erro = true;
		}
		if (document.consulta.ccto.value == '' || document.consulta.ccto.value == null) {
		alert("Digite um numero de circuito.");
		erro = true;
		}
		if (erro == false) {
		NovaJanela("historicov.php?ccto="+document.consulta.ccto.value+"&filial="+document.consulta.filial.value+"&consulta=1","Consulta","750","600","yes");
		}
}

function NovaJanela(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',status=0,toolbar=0,location=0,menubar=0';
	win = window.open(pagina,nome,settings);
}

function cns(value) {

	if(value == 0) {
	
	document.location = "consulta.php";

	}
	else {

	document.getElementById("consulta2").src = "consulta2.php?mes="+value;

	}
}

function ano(valor) {
	if(valor == '#') {
	document.location.href =  'consulta.php';
	}
	else {
	document.location.href = "consulta.php?ano="+valor;
	}
}
function mes(valor) {
	if(valor == '#') {
	document.location.href =  'consulta.php?ano='+get1['ano'];
	}
	else {
	document.getElementById("consulta2").src = "consulta2.php?ano="+get1['
    ']+"&mes="+valor;
	}
}


</script>

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

<style type="text/css">
body{

background-repeat: repeat-y;
background-color: #FFFFFF;
background-position: center;
background-image:url(bg.png);
margin-top: 0;
font-weight:
}

.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
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

.style5 {font-size: 12}
.topo  {display: block;}
.style4 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
body{ 

	overflor-x: hidden;

}

table.legenda th {
height: 30px;
font-family: Arial, Helvetica, sans-serif;
font-size: 13px;
}

table.legenda td {
font-family: Arial, Helvetica, sans-serif;
font-size: 12px;
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
   <td><div align="center" class="style1"><a href="index.php">Início</a></div></td>
   <td rowspan="3"><div align="center" class="style1"><img name="topo_r2_c3" src="imagens\topo_r2_c3.png" width="15" height="20" border="0" id="topo_r2_c3" alt="" /></div></td>
   <td><div align="center" class="style1"><a href="ausencia.php">Aus&ecirc;ncias</a></div></td>
   <td rowspan="3"><div align="center" class="style1"><img name="topo_r2_c5" src="imagens\topo_r2_c5.png" width="19" height="20" border="0" id="topo_r2_c5" alt="" /></div></td>
   <td><div align="center" class="style1"><a href="registro.php">Registro</a></div></td>
   <td rowspan="3"><div align="center" class="style1"><img name="topo_r2_c7" src="imagens\topo_r2_c7.png" width="18" height="20" border="0" id="topo_r2_c7" alt="" /></div></td>
   <td><div align="center" class="style1"><a href="consulta.php">Consulta</a></div></td>
   <td rowspan="3"><div align="center" class="style1"><img name="topo_r2_c9" src="imagens\topo_r2_c9.png" width="18" height="20" border="0" id="topo_r2_c9" alt="" /></div></td>
   <td><div align="center" class="style1"><a href="admin.php">Gráficos</a></div></td>
   <td rowspan="3"><div align="center" class="style1"><img name="topo_r2_c11" src="imagens\topo_r2_c11.png" width="15" height="20" border="0" id="topo_r2_c11" alt="" /></div></td>
   <td><div align="center" class="style1"><a href="sobre.php">Sobre</a></div></td>
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
</center>



<br>
<table width="843" border="0" align="center">
  <tr>
    <td colspan='3'><div align="center"><span class="style3">Meus Circuitos</span></div></td>
  </tr>
  <tr>
    <td colspan='3'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='3'>&nbsp;</td>
  </tr>
  <tr>
<td width='250px'><!-- Legenda -->
<table class='legenda'>
<tr><th colspan='2' align='center'>Legenda</th></tr>
<tr>
<td><img src='imagens/pendok.png' width='20px' height='20px'></td><td width='250px'>Pend&ecirc;ncia OK.</td>
</tr>
<tr>
<td><img src='imagens/pender.png' width='20px' height='20px'></td><td>Circuito Pendenciado.</td>
</tr>
<tr>
<td><img src='imagens/Objon.png' width='20px' height='20px'></td><td>Completo OBJECTEL.</td>
</tr>
<tr>
<td><img src='imagens/Objoff.png' width='20px' height='20px'></td><td>Incompleto OBJECTEL.</td>
</tr>
<tr>
<td><img src='imagens/Objns.png' width='20px' height='20px'></td><td>N&atilde;o consta status do OBJECTEL para este circuito.</td>
</tr>
</tr>
</table>
<!-- Fim Legenda --></td>
    <td ><div align="right" class="style2"><?php 
		if($_SESSION['level'] > 3) {
		echo "&nbsp;";
		}
		else {
		$con = conectar();

		$x=0;
		$query = mysql_query("SELECT DISTINCT `data_e` FROM `tabelacptx`");
		if(mysql_num_rows($query) == 0) {
		exit;
		}


		echo "Ano: ";

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
		echo "&nbsp;&nbsp;&nbsp;&nbsp;Mês: ";
		if(!isset($_GET['ano'])) {
			$ano = date("Y");
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
				if(isset($_GET['mes'])){
					if($_GET['mes'] == $mes) {
					echo "selected='selected'";
					}
				}
				echo ">$mes</option>";
			}
		echo "</select>";
		}
		
}


?>
        </select>
    </div></td>
<form name='consulta'>

<td class='style2'>&nbsp;&nbsp;&nbsp;&nbsp;Hist&oacute;rico de: <select name="filial" id="filial" style="font-family:Arial, Helvetica, sans-serif; background-image:url(fundo1.png)" >
		<?php
		$filiais = array('FNS','PAE','BSA','GNA','CPE','CBA','CTA','PVO','RBO','PLT');
		$n_filiais = count($filiais);
		if(isset($_GET['filial'])) {
			echo "<option value=\"#\"></option>";
			for($x=0; $x<$n_filiais; $x++) {
			echo "<option value=\"$filiais[$x]\"";
				if($_GET['filial'] == $filiais[$x]) {
				echo " selected=\"selected\"";
				}
			echo ">$filiais[$x]</option>";
			}
		}
	else {
		echo "<option value=\"#\" selected=\"selected\"></option>";
		for($x=0; $x<$n_filiais; $x++) {
				echo "<option value=\"$filiais[$x]\">$filiais[$x]</option>";
		}
	}
?>
        </select>&nbsp;&nbsp;&nbsp;<input type='text' size='7'  maxlength='7' name='ccto' id='ccto'>&nbsp;&nbsp;&nbsp;<input type='button' value='Consultar' onclick='consultar();'></td></form>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='3'><table width="100%" border="0">
      <tr><td width="39%"><?php
		if($_SESSION['level'] > 3) {

		}
		else {
echo  "<iframe src=\"consulta2.php"; if(isset($_GET['ano'])) { echo "?ano=".$_GET['ano']; } echo "\" id=\"consulta2\" name=\"consulta2\" scrolling=\"no\" frameborder='0' width=\"100%\" height=\"550px\"></iframe>";
	  	}
?>
	  </td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
