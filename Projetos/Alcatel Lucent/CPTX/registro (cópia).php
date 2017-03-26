<?php include("funcoes.php");

logout();

function c_circ($circ) {

$con = conectar();
$hoje = hoje();
$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `circuito` = '$circ' and `data_e` = '$hoje'");
ver_mysql($query);
mysql_close($con);

}

 ?>
<html>
<title>CPTX - Registro</title>

<style type="text/css">
<!--
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
-->


</style><head>

<?php 
echo "<script language='javascript'>\n";

	echo "function rat(){\n";
	echo "document.getElementById('comentario').disabled = 1;\n";
	echo "document.getElementById('velocidade').disabled = 1;\n";
	echo "document.getElementById('check').disabled = 1;\n";

	if(!isset($_SESSION['log_tx']) or $_SESSION['level'] > 10) {
	echo "var camp = new Array();\n";

	echo "document.getElementById('circuito').disabled = 1;\n";
	echo "document.getElementById('filial').disabled = 1;\n";
	echo "document.getElementById('check').disabled = 1;\n\n";

	}
	echo "}\n\n</script>";


?>



<!-- European format dd-mm-yyyy -->
<script language="JavaScript" src="calendar\calendar1.js"></script><!-- Date only with year scrolling -->
<!-- American format mm/dd/yyyy -->
<script language="JavaScript" src="calendar\calendar2.js"></script><!-- Date only with year scrolling -->

<script language='javascript'>

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
var vez = get1['inserido'];

function onload() {
	if((get1['ccto'] != '' || get1['ccto'] != null) && (get1['filial'] != '' || get1['filial'] != null)) {
	document.getElementById("historico").src = 'historico.php?ccto='+document.getElementById("circuito").value+'&filial='+document.getElementById("filial").value;
	}
}


function CkClick() {

	if(document.getElementById('check').checked == true) {
	document.getElementById('velocidade').disabled = 0;
	document.getElementById('velocidade').value = '';
	document.getElementById('velocidade').focus();
	}
	else {
	document.getElementById('velocidade').disabled = 1;
	document.getElementById('velocidade').value = 'E1';
	}
}

function verificador() {

var select = document.getElementById("filial").value;
var ccto = document.getElementById("circuito").value;

	if(ccto.length == 7 && select != '#') {
	return false;
	}
	else {
	return true;
	}
}

function sniffer() {
var parar = verificador();
	if(parar == true) {
	document.getElementById("ins_hid").style.display = 'block';
	document.getElementById("historico").style.display = 'none';
	document.getElementById("check").disabled = true;
	document.getElementById("comentario").disabled = true;
	document.getElementById("l_vel").style.display = 'none';
	document.getElementById("l_com").style.display = 'none';
	document.getElementById("l_data").style.display = 'none';
	document.getElementById("l_pen").style.display = 'none';
	document.getElementById("l_par").style.display = 'none';
	return;
	}
	document.getElementById("ins_hid").style.display = 'none';
	document.getElementById("comentario").disabled = false;
	document.getElementById("check").disabled = false;
	document.getElementById("historico").style.display = 'block';
	if(vez == 1) {
	document.getElementById("historico").src = 'historico.php?&ins=1&ccto='+document.getElementById("circuito").value+'&filial='+document.getElementById("filial").value;
	vez += 1;
	}
	else {
	document.getElementById("historico").src = 'historico.php?ccto='+document.getElementById("circuito").value+'&filial='+document.getElementById("filial").value;
	}

}


function swap_pen(id) {
document.getElementById(id).checked = true;
	
	//clicou no não
	if(id == "penn") {
		document.getElementById("v.obj").style.display = 'none';
		document.getElementById("pens").checked = false;
		document.getElementById("l_obj").style.display = 'block';
		document.getElementById("l_cpen").style.display = 'none';
		document.getElementById("l_par").style.display = 'none';
	}
	//clicou no sim
	if(id == "pens") {
		document.getElementById("inco").checked = false;
		document.getElementById("comp").checked = true;
		document.getElementById("v.obj").style.display = 'none';
		document.getElementById("penn").checked = false;
		document.getElementById("l_obj").style.display = 'none';
		document.getElementById("l_cpen").style.display = 'block';
		document.getElementById("l_par").style.display = 'block';
	}
}

function swap(id) {
document.getElementById(id).checked = true;
	if(id == "comp") {
		document.getElementById("inco").checked = false;
		document.getElementById("v.obj").style.display = 'none';
		document.getElementById("t_sobj").value = 'completo';

	}
	if(id == "inco") {
		document.getElementById("comp").checked = false;
		document.getElementById("v.obj").style.display = 'block';
		document.getElementById("t_sobj").value = 'incompleto';

	}
}



function loader() {

rat();
sniffer();
verificador();

}


</script>

<style type="text/css">
body{
overflow-y: hidden;
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
<body onLoad="loader();">

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
   <td><div align="center" class="style4"><a href="index.php">Início</a></div></td>
   <td rowspan="3"><div align="center" class="style4"><img name="topo_r2_c3" src="imagens\topo_r2_c3.png" width="15" height="20" border="0" id="topo_r2_c3" alt="" /></div></td>
   <td><div align="center" class="style4"><a href="ausencia.php">Aus&ecirc;ncias</a></div></td>
   <td rowspan="3"><div align="center" class="style4"><img name="topo_r2_c5" src="imagens\topo_r2_c5.png" width="19" height="20" border="0" id="topo_r2_c5" alt="" /></div></td>
   <td><div align="center" class="style4"><a href="registro.php">Registro</a></div></td>
   <td rowspan="3"><div align="center" class="style4"><img name="topo_r2_c7" src="imagens\topo_r2_c7.png" width="18" height="20" border="0" id="topo_r2_c7" alt="" /></div></td>
   <td><div align="center" class="style4"><a href="consulta.php">Consulta</a></div></td>
   <td rowspan="3"><div align="center" class="style4"><img name="topo_r2_c9" src="imagens\topo_r2_c9.png" width="18" height="20" border="0" id="topo_r2_c9" alt="" /></div></td>
   <td><div align="center" class="style4"><a href="admin.php">Gráficos</a></div></td>
   <td rowspan="3"><div align="center" class="style4"><img name="topo_r2_c11" src="imagens\topo_r2_c11.png" width="15" height="20" border="0" id="topo_r2_c11" alt="" /></div></td>
   <td><div align="center" class="style4"><a href="sobre.php">Sobre</a></div></td>
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






</center><br>

<!-- Tabela que engloba BODY -->
<table width="843" border="0" align="center">

 <tr>
    <td><div align="center" class="style3">Registro de Circuitos</div></td>
 </tr>
 <tr>
    <td>

<!-- Começo da tabela -->
<table align='center' border='0' width='100%' height='500px'>
<tr><td valign='top'>
	
<!-- Tabela do E1 -->

	<table width="100%" border="0" align="center" id="tab_fe" style="display: block;" class="style1">

     <tr height='40px'>
        <td width="45%" align="right">Circuito: </td>
        <td width="55%" align="left" valign="middle"><select name="filial" id="filial" style="font-family:Arial, Helvetica, sans-serif; background-image:url(fundo1.png)"  onChange="sniffer();">
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
     </select>
	<!-- Campo de texto do Circuito -->	
	<input type='text' onFocus="this.style.backgroundColor='#B3FFB3'" onBlur="this.style.backgroundColor=''" onkeyup="sniffer();" onChange="sniffer();" name="circuito" id="circuito" maxlength='7' size='7'><br></td>
<?php
if(isset($_GET['inserido'])) {
	if($_GET['inserido'] == 1) {
	echo "<tr><td colspan='2' id='ins_hid'><center class=style1>O circuito $_GET[filial] $_GET[ccto] foi incluido com sucesso.</center></td></tr>";
	}
}
else {
echo "<tr><td colspan='2' id='ins_hid' style='display: none;'></td></tr>";
}
?>
	<tr id='l_vel' style='display: none';>
	<!-- Campo de texto da Velocidade -->
	   <td align='right'>&nbsp;Velocidade:</td><td><input type='text' onFocus="this.style.backgroundColor='#B3FFB3'" onBlur="this.style.backgroundColor=''" value='E1' name="velocidade" id="velocidade" maxlength='5' size='4'>
	<!-- Checkbox da velocidade (FE) -->
	   FE <input type='checkbox' id='check' alt="Clique aqui se o  circuito for Fast Enthernet" onClick='CkClick()'></td>
      </tr>
	<!-- Comentario -->
	<tr id='l_com' style='display: none;'>
	<td align='right'>&nbsp;Coment&aacute;rio:</td><td><input type='text' onFocus="this.style.backgroundColor='#B3FFB3'" onBlur="this.style.backgroundColor=''" name="comentario" id="comentario" maxlength='10000' size='50' <?php
 if(isset($_POST['res_com'])) { 
echo "value=$_POST[res_com]"; } 
?>>
</td>
      </tr>
      <tr id='l_data' style='display: none'>
        <td height="40px" class="style1" align="right">Data de execu&ccedil;&atilde;o:</td>
        <td width="226" align="left" valign="middle">

<form name="form_fe" action="inserir.php?mod=inserir" method="post">

<input type='text' style='display: none;' name="t_circuito" id="t_circuito">
<input type='text' style='display: none;' name="t_velocidade" id="t_velocidade">
<input type='text' style='display: none;' name="t_filial" id="t_filial">
<input type='text' style='display: none;' name="t_comentario" id="t_comentario">
<input type='text' style='display: none;' name="data_c" id="data_c">
<input type='text' style='display: none;' name="t_sobj" id="t_sobj">
<input type='text' style='display: none;' name="t_robj" id="t_robj">
<input type='text' style='display: none;' name="t_cpen" id="t_cpen">
<input type='text' style='display: none;' name="t_obj" id="t_obj">
<input type='text' style='display: none;' name="t_pen" id="t_pen">
<label>
           <input type="text" name="data_e" id="data_e" onFocus="this.style.background='#00FF33';" onBlur="this.style.background='#ffffff';" size='10'>
<a href="javascript:cal1.popup();"><img src="calendar/img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para selecionar uma data"></a>
            </label><a href="#"><img src="imagens/icon_limpar.gif" width="16" height="16" border="0" alt="Apagar data" onClick="document.forms['form_fe'].data_e.value=''" /></a>
</form>

	</td>
<tr id='l_pen'><td align='right'>Pend&ecirc;ncia: </td>
<td><input type='radio' name='penn' id='penn' onclick='swap_pen(this.id)'>N&atilde;o	<input name='pens' id='pens' type='radio' onclick='swap_pen(this.id)'>Sim	 </td></tr><tr height='30px' id='l_cpen' style='display: none;'><td colspan='2' align='center'>
<select name='cpen' id='cpen'>
<option value='4026'>4026 - COMERCIAL</option>
<option value='3500'>3500 - RPI</option>
<option value='3031'>3031 - GPRD</option>
</select></td></tr>
<tr id='l_par' style='display: none'><td colspan='2' align='center'>Parecer: <input type='text' size='30' name='r_pend' id='r_pend'></td></tr>
<tr id='l_obj' style='display: none'><td align='right'>Status do Objectel: </td>
<td><input type='radio' name='comp' id='comp' onclick='swap(this.id)'>Completo	<input name='inco' id='inco' type='radio' onclick='swap(this.id)'>	Incompleto</tr><tr id='v.obj' style='display:none;'><td colspan='2' align='center'>Motivo: <input type='text' name='robj' id='robj'  size='30'></td></tr>
      </td></tr>
    </table>
</td>
</tr>
<tr>
<td>
<!-- Frame do Histórico -->
<iframe src='historico.php' id='historico' width='100%' height='625px' frameborder='0' scrolling='auto' style="display: none;" ></iframe>
</td>
</tr>
</table>
	
	
	</td>
  </tr>
  <tr><td align="center">
    <input type="button" id="button" onClick="javascript: submitor();" value="Enviar" style="display:none;"></td>
  </tr>
</table>
<br><br><br>
<div align='center' class='rodape' id='rodape'>
Campos com * s&atilde;o obrigat&oacute;rios.
</div>

			<script language="JavaScript">
				 // create calendar object(s) just after form tag closed
				 // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
				 // note: you can have as many calendar objects as you need for your application
				document.form_fe.data_e.disabled = 1;
				var cal1 = new calendar1(document.forms['form_fe'].elements['data_e']);
				cal1.year_scroll = true;
				cal1.time_comp = false;

			</script>
</body>
</html>
<?php
if($_SESSION['level'] == 3) {
echo "<script language='JavaScript'>

document.getElementById('filial').disabled = 1;
document.getElementById('circuito').disabled = 1;


</script>";
}
?>
