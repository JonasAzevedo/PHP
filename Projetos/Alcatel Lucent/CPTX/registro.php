<?php include("funcoes.php");

logout();

?>
<html>
<title>CPTX - P&aacute;gina Inicial</title>

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
.topo  {display: block;}
.style4 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }



#reserva {
	position:absolute;
	left:804px;
	top:108px;
	width:231px;
	height:136px;
	z-index:1;
	background-color: #C7C7C7;
	border:  solid 1px #000000;
}
</style>


<head>
<!-- European format dd-mm-yyyy -->
<script language="JavaScript" src="./calendar/calendar1.js"></script><!-- Date only with year scrolling -->
<!-- American format mm/dd/yyyy -->
<script language="JavaScript" src="./calendar/calendar2.js"></script><!-- Date only with year scrolling -->

<script language='javascript'>
function sair(){
location.href='redirecionar.php?sair=1';
}

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') +  1).split('&');
 
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


var win = null;
function NovaJanela(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars=yes,status=0,toolbar=0,location=0,menubar=0';
	win = window.open(pagina,nome,settings);
}

function red(mod) {
NovaJanela('vertab.php?mod='+mod,'Circuitos','450','450','yes');
}

//Com Pendência
function pendencia_s(id) {

document.getElementById(id).checked = true;
document.getElementById('pen_nao').checked = false;
document.getElementById('frm_pendencia').src = "ver_pen.php?ccto="+document.getElementById('circuito').value+"&filial="+document.getElementById('filial').value;

//Tem que aparecer Código e Parecer caso haja pendência
document.getElementById("lin_cod").style.display = "block";
document.getElementById("lin_pen_par").style.display = "block";

//Limpando
document.getElementById('obj_sim').checked = false;
document.getElementById('obj_nao').checked = false;
esconder_obj();

}

//Pêndencia Não
function pendencia_n(id) {
document.getElementById(id).checked = true;
document.getElementById('pen_sim').checked = false;
document.getElementById('frm_pendencia').src = "ver_pen.php?ccto="+document.getElementById('circuito').value+"&filial="+document.getElementById('filial').value;


//Caso NÃO há pendência, deve-se esconder o parecer e o código
document.getElementById("lin_cod").style.display = "none";
document.getElementById("lin_pen_par").style.display = "none";

mostrar_obj();

}

function mostrar_obj() {
document.getElementById("lin_obj").style.display = "block";

}

function  esconder_obj() {

document.getElementById("lin_obj").style.display = "none";
document.getElementById("lin_obj_par").style.display = "none";
document.getElementById("lin_obj_frm").style.display = "none";
}

function esconder_pen() {
document.getElementById("lin_pen").style.display = "none";
document.getElementById("lin_pen_frm").style.display = "none";
document.getElementById("lin_pen_par").style.display = "none";
document.getElementById("lin_pen_new").style.display = "none";
document.getElementById("lin_cod").style.display = "none";

}

//Objectel Completo
function obj_s(id) {
document.getElementById(id).checked =  true;
document.getElementById("obj_nao").checked = false;
document.getElementById("lin_
par").style.display = "none";
document.getElementById('frm_objectel').src = "ver_obj.php?ccto="+document.getElementById('circuito').value+"&filial="+document.getElementById('filial').value;


}

//Objectel Incompleto
function obj_n(id) {
document.getElementById(id).checked =  true;
document.getElementById("obj_sim").checked = false;
document.getElementById("lin_obj_par").style.display = "block";
document.getElementById('frm_objectel').src = "ver_obj.php?ccto="+document.getElementById('circuito').value+"&filial="+document.getElementById('filial').value;
}

function transpor() {
document.form_registro.t_circuito.value = document.getElementById('circuito').value;
document.form_registro.t_filial.value = document.getElementById('filial').value;
document.form_registro.t_velocidade.value = document.getElementById('velocidade').value;
document.form_registro.t_data_e.value = document.form_mnt.data_e.value;
document.form_registro.t_observacao.value = document.getElementById('mmObs').value;

}

function submitaus() {

if (document.getElementById("pen_sim").checked == true) {
//Proteções
	if (document.getElementById("pen_par").value == "") {
	alert("Voce precisa preencher o campo parecer.");
	return;
	}	
	
//Transpondo
	transpor();
	document.form_registro.t_codigo.value = document.getElementById('pen_cod').value;
	document.form_registro.t_parecer.value = document.getElementById('pen_par').value;
	
	document.form_registro.action = "inserir.php?mod=ins_pen_sim";
	liberar();
	document.form_registro.submit();
	return;
}

//Não há pendência
if (document.getElementById("pen_nao").checked == true) {
	//Objectel Completo
	if(document.getElementById("obj_sim").checked == true) {

	document.getElementById("t_parecer").value = "COMPLETO";
		if(document.getElementById("obj_pen").disabled == false) {
		document.form_registro.t_parecer_pen.value = document.getElementById("obj_pen").value;
		}
	document.form_registro.action = "inserir.php?mod=ins_pen_nao_obj_sim";
	liberar();
	document.form_registro.submit();
	return;
	}
	//Objectel Incompleto
	if(document.getElementById("obj_nao").checked == true) {
		if (document.getElementById("obj_par").value == "") {
		alert("Voce precisa preencher o campo parecer.");
		return;
		}
	transpor();
	document.getElementById("t_parecer").value = document.getElementById("obj_par").value;
	if(document.getElementById("obj_pen").disabled == false) {
		document.form_registro.t_parecer_pen.value = document.getElementById("obj_pen").value;
	}
	document.form_registro.action = "inserir.php?mod=ins_pen_nao_obj_nao";
	liberar();
	document.form_registro.submit();
	return;
	}


}
alert("Favor preencher os campos.");

}

function liberar() {
document.getElementById('velocidade').disabled = 0;
document.form_mnt.data_e.disabled = false;
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
	document.getElementById('velocidade').disabled = true;
	document.getElementById('E1').disabled = true;
	esconder_pen();
	esconder_obj();
	document.getElementById('frm_pendencia').style.display = "none";
	}
	else {
	document.getElementById('frm_pendencia').src = "ver_pen.php?ccto="+document.getElementById('circuito').value+"&filial="+document.getElementById('filial').value;
	document.getElementById('frm_pendencia').style.display = "block";
	document.getElementById('lin_pen').style.display = "block";
	document.getElementById('velocidade').disabled = true;
	document.getElementById('E1').disabled = false;
	}
}

function E1() {

	if(document.getElementById('E1').checked == true) {
	document.getElementById('velocidade').disabled = 0;
	document.getElementById('velocidade').value = '';
	document.getElementById('velocidade').focus();
	}
	else {
    document.getElementById('velocidade').disabled = 1;
	document.getElementById('velocidade').value = 'E1';
	}
}

function reservar() {
//Proteção
if(document.getElementById('res_ccto').value == '') {
alert("Digite um numero para o circuito!");
return;
}
if(document.getElementById('res_filial').value == '#') {
alert("Selecione uma filial!");
return;
}

document.reserva.t_res_ccto.value = document.getElementById('res_ccto').value;
document.reserva.t_res_filial.value = document.getElementById('res_filial').value;

document.reserva.submit();
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
	font-size: 12px;
}
#topo {
	background-color:#FFFFFF;
	top: 0px;

}

table.registro  {
font-size:12px;
font-family:Arial, Helvetica, sans-serif;
}
table.registro th {
font-size:16px;
font-weight: bold;
font-family:Arial, Helvetica, sans-serif;
text-align:center;
height: 40px;
}
.direita {
text-align:right;
}

table.tabela_reserva {
font-family:Arial, Helvetica, sans-serif;
}


table.tabela_reserva th {
font-size:16px;
text-align:center;
}

table.tabela_reserva td {
font-size:12px;
}

</style>
</head>
<body>





<center>

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
<br><br>
<!-- Começo da Tabela registro  -->
<table align="center" width="848px" class="registro" cellpadding="3px">
<tr class="direita">




  <th colspan="2" valign="top" scope="col">Registro de Circuitos</th></tr>
<tr>
<td width="238" class="direita">Circuito: </td>
<td width="590"><select name="filial" id="filial" onChange="sniffer();">	
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
</select>&nbsp;&nbsp;&nbsp;<input name="circuito" type="text" id="circuito" size="7" maxlength="7"  onKeyUp="sniffer();" onChange="sniffer();"></td>
</tr>
<tr>
  <td class="direita">Velocidade: </td>
  <td><input name="velocidade" type="text" id="velocidade" size="4" maxlength="5" value="E1">
  &nbsp;&nbsp;<input name="E1" type="checkbox" id="E1" value="" onClick="E1(this.id);">
  FE</td>
</tr>
<tr>
  <td class="direita">Data de Execu&ccedil;&atilde;o: </td>
  <td><form name="form_mnt" id='form_mnt'><input name="data_e" type="text" id="data_e" size="10" maxlength="10"> 
<a href="javascript:cal1.popup();"><img src="calendar/img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para selecionar uma data"></a>&nbsp;
    <input type="image" name="imageField2"  width="20px"  height="20px"src="imagens/icon_limpar.gif"></form>
	<script language="JavaScript">
				 // create calendar object(s) just after form tag closed
				 // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
				 // note: you can have as many calendar objects as you need for your application
				document.getElementById('data_e').disabled = true;
				var cal1 = new calendar1(document.forms['form_mnt'].elements['data_e']);
				cal1.year_scroll = false;
				cal1.time_comp = false;
			</script>	</td>
</tr>
<tr>
  <td class="direita">Observação:</td>
  <td> <textarea name="mmObs" id="mmObs"></textarea> </td>
</tr>
<tr id='lin_pen'>
  <td height="27" class="direita">Pend&ecirc;ncia</td>
  <td><input name="pen_nao"  id="pen_nao"  type="radio" value="radiobutton" onClick="pendencia_n(this.id);">
    N&atilde;o&nbsp;&nbsp;&nbsp;
      <input name="pen_sim" id="pen_sim"  type="radio" value="radiobutton" onClick="pendencia_s(this.id);">
      Sim</td>
</tr>
<tr id="lin_pen_frm" style="display:none">
  <td height="34" colspan="2" align="center"><iframe frameborder="0" name='frm_pendencia'  id='frm_pendencia' width="400px" height="150px"></iframe></td>
  </tr>
<tr id="lin_pen_new" style="display:none;">
  <td height="34" class='direita'>&nbsp;</td>
  <td height="34">Nova Pend&ecirc;ncia:</td>
</tr>
<tr id="lin_cod" style="display:none;">
  <td height="34" class='direita'><label name="lab_pen_cod" id="lab_pen_cod">C&oacute;digo</label>
    de Pend&ecirc;ncia 
    : </td>
  <td height="34"><select name="pen_cod" id="pen_cod">
    <option value='4026'>4026 - COMERCIAL</option>
    <option value='3500'>3500 - RPI</option>
    <option value='3031'>3031 - GPRD</option>
  </select></td>
</tr>
<tr id="lin_pen_par" style="display:none;">
  <td height="34" class='direita' >Justificativa:  </td>
  <td height="34"><input name="pen_par" type="text" id="pen_par" size="40"></td>
</tr>
<tr id="lin_obj_pen" style="display:none">
  <td height="34" class='direita'>Justificativa Pend&ecirc;ncia: </td>
  <td height="34"><input name="obj_pen" type="text" id="obj_pen" size="40"></td>
</tr>
<tr id="lin_obj" style="display:none">
  <td height="34" class='direita'>Status do Objectel: </td>
  <td height="34"><input name="obj_sim" id='obj_sim' onClick="obj_s(this.id);" type="radio" value="radiobutton">
    Completo
    &nbsp;&nbsp;&nbsp;
    <input name="obj_nao" id='obj_nao' type="radio" onClick="obj_n(this.id);" value="radiobutton"> 
    Incompleto</td>
</tr>
<tr id="lin_obj_frm"  style="display:none">
  <td height="34" colspan="2" align="center"><iframe frameborder="0"  width="400px" height="150px" name="frm_objectel" id="frm_objectel"></iframe></td>
  </tr>
  <tr id="lin_obj_par"  style="display:none">
    <td height="34" class="direita">Justificativa: </td>
	<td height="34"><input name="obj_par" type="text" id="obj_par" size="40"></td>
  </tr>
  <tr>
  <td height="34" colspan="2" align="center"><input type="button" value="Inserir"  id='botao' onClick="submitaus();"></td>
  </tr>
</table>

<form id="form_registro" name="form_registro" method="post">
<input type="hidden" id="t_circuito" name="t_circuito">
<input type="hidden" id="t_filial" name="t_filial">
<input type="hidden" id="t_velocidade" name="t_velocidade">
<input type="hidden" id="t_data_e" name="t_data_e">
<input type="hidden" id="t_observacao" name="t_observacao">
<input type="hidden" id="t_codigo" name="t_codigo">
<input type="hidden" id="t_parecer" name="t_parecer">
<input type="hidden" id="t_parecer_pen" name="t_parecer_pen">
</form>

</body>
</html>
<script>
document.getElementById('obj_pen').disabled = 1;
document.getElementById('velocidade').disabled = 1;
document.getElementById('E1').disabled = 1;
document.getElementById('lin_pen').style.display = "none";
document.form_mnt.disabled = 1;

</script>
