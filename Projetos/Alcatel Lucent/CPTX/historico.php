<?php include("funcoes.php");

if(!isset($_GET['ins'])){
$_GET['ins'] = 0;
}

function c_circ($circ) {

$con = conectar();
$hoje = hoje();
$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `circuito` = '$circ' and `data_e` = '$hoje'");
$n = mysql_num_rows($query);
ver_mysql($query);
mysql_close($con);

return $n;

}

if(!isset($_GET['ccto']) || !isset($_GET['filial'])){
exit;
}
if(!isset($_GET['consulta'])){
$_GET['consulta'] = 0;
}
?>
<html>
<head>
<!-- European format dd-mm-yyyy -->
<script language="JavaScript" src="calendar\calendar1.js"></script><!-- Date only with year scrolling -->
<!-- American format mm/dd/yyyy -->
<script language="JavaScript" src="calendar\calendar2.js"></script><!-- Date only with year scrolling -->
<script>
function submitor() {

//verificando se o cara escreveu...

if((window.parent.comp.checked == false && window.parent.inco.checked == false) && window.parent.penn.checked == true){
alert("Defina um status para o Objectel.");
//window.parent.form_fe.t_robj.value = "nao definido";
//window.parent.form_fe.t_sobj.value = "incompleto";
return;
}

//Objectel
if(window.parent.inco.checked == true && (window.parent.robj.value == '' || window.parent.robj.value == null)){
alert("Você precisa explicar o por que dele nao estar completado.");
return;
}

//Pendencia
if((window.parent.r_pend.value == "" || window.parent.r_pend.value == null) && window.parent.pens.checked == true){
alert("Voce precisa deixar um parecer desta pendencia.");
return;
}

if(window.parent.comp.checked == true && window.parent.penn.checked == true) {
window.parent.robj.value = "COMPLETO";
}


window.parent.form_fe.t_circuito.value = window.parent.circuito.value;
window.parent.form_fe.t_velocidade.value = window.parent.velocidade.value;
window.parent.form_fe.t_filial.value = window.parent.filial.value;
window.parent.form_fe.t_comentario.value = window.parent.comentario.value;
window.parent.form_fe.t_robj.value = window.parent.robj.value;
window.parent.form_fe.t_cpen.value = window.parent.cpen.value;
window.parent.form_fe.t_pen.value = window.parent.r_pend.value;

//Verificando se há pêndencia ou não
if(window.parent.pens.checked ==  true) {
window.parent.form_fe.action = "inserir.php?mod=compen";
}
else {
	window.parent.form_fe.action = "inserir.php?mod=sempen";
	if(window.parent.comp.checked == true) {
	window.parent.form_fe.t_sobj.value = 1;
	}
	else {
	window.parent.form_fe.t_sobj.value = 0;
	}
}

window.parent.form_fe.data_e.disabled = false;
window.parent.form_fe.submit();
}

function getUrlVarsPup()
{

    var vars = [], hash;
    var hashes = window.parent.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
 
    for(var i = 0; i < hashes.length; i++)
    {	
        hash = hashes[i].split('=');
		hash[1] = unescape(hash[1]);
		vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
 
    return vars;
}

function submitcomment() {
	if (document.form_ic.com.value == '' || document.form_ic.com.value == null) {
	alert("Voce precisa escrever um comentario!");
	return false;
	}
	else {
	document.form_ic.data_p.disabled = false;
	document.form_ic.submit();
	}
}
function submitnovamente() {
	if (document.form_nov.just.value == '' || document.form_nov.just.value == null) {
	alert("Voce precisa escrever uma justificativa!");
	return false;
	}
	else {
	document.form_nov.submit();
	}
}

function swap(id) {
document.getElementById(id).checked = true;
	if(id == "sim") {
		document.getElementById("nao").checked = false;
		document.getElementById("just2").style.display = 'block';


	}
	if(id == "nao") {
		document.getElementById("sim").checked = false;
		document.getElementById("just2").style.display = 'none';

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
	font-size: 14px;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
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
<?php 

if (verificar_circ($_GET['filial'],$_GET['ccto']) == true) {
	if(verificar_circ_dia($_GET['filial'],$_GET['ccto']) > 0) {
		if($_GET['ins'] != 1) {
		echo "<form name='form_nov' id='form_nov' action='inserir.php?mod=insnov' method='post'>";
		echo "<input type='hidden' id='ccto' name='ccto' value='$_GET[ccto]'>";
		echo "<input type='hidden' id='filial' name='filial' value='$_GET[filial]'>";
		echo "<br>";
		echo "<center class=style1>";
		$x = c_circ($_GET['ccto']);
		//Aviso e Inserção pela segunda vez...
		echo "O Circuito <u>$_GET[filial]</u> <u>$_GET[ccto]</u> j&aacute; foi inserido hoje $x ";
		if($x == 1) { echo "vez"; } else { echo "vezes"; } echo ". Deseja inseri-lo novamente ?";
		echo "<input type='radio' id='sim' onclick='swap(this.id)'> Sim / <input type='radio' id='nao' onclick='swap(this.id)'> N&atilde;o";
		echo "<span id='just2' style='display: none;'";
		echo "</center>";
		echo "<center class=style1>";
		echo "Justifique o por que dele estar sendo inserido novamente neste dia.";
		echo "</center>";
		echo "<br>";
		echo "<center class=style1>";
		echo "Justificativa: <input type='text' id='just' name='just' size='50'>";
		echo "<input type='hidden' id='ccto' value='$_GET[ccto]'>";
		echo "<input type='hidden' id='filial' value='$_GET[filial]'>";
		echo "</center>";
		echo "<br>";
		echo "<center>";
		echo "<input type='button' onClick='submitnovamente(\"$_GET[filial]\",\"$_GET[ccto]\")' value='Inserir'>";
		echo "</center>";
		echo "</span>";
		echo "</form>";
		}

		echo "<br>";


		echo "
		<br>
		<script>
		window.parent.comentario.disabled=1;
		</script>
	
		<br>


		<br><br><br>

		<form style='display: none;' name='form_ic' action='inserir.php?mod=inscom&ccto=$_GET[ccto]&filial=$_GET[filial]' method='post'>
	

		<center>
	<span class='style1' style = 'display: none'>Adicionar Coment&aacute;rio: <br><input type = 'text' id='com' name='com' size ='35' maxlength='1000'></span>
&nbsp;&nbsp;&nbsp;&nbsp;

<input type=\"text\" name=\"data_p\" id=\"data_p\" onFocus=\"this.style.background='#00FF33';\" onBlur=\"this.style.background='#ffffff';\" size='10'>

<a href=\"javascript:cal1.popup();\">
<img src=\"calendar/img/cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Clique aqui para selecionar uma data\">
</a>

<a href=\"#\"><img src=\"imagens/icon_limpar.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Apagar data\" onClick=\"document.forms['form_ic'].data_p.value=''\" /></a>


	</center>
		<center><input type='button' value='Adicionar Comentario' onclick='submitcomment();'></center>
		</form>
		<script language=\"JavaScript\">
				 // create calendar object(s) just after form tag closed
				 // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
				 // note: you can have as many calendar objects as you need for your application
				document.form_ic.data_p.disabled = 1;
				var cal1 = new calendar1(document.forms['form_ic'].elements['data_p']);
				cal1.year_scroll = true;
				cal1.time_comp = false;

			</script>";

		}
	else {
	echo "<script>";
	echo "window.parent.l_vel.style.display = \"block\";";
	echo "window.parent.l_com.style.display = \"block\";";
	echo "window.parent.l_pen.style.display = \"block\";";
	echo "window.parent.l_data.style.display = \"block\";";
	echo "</script>";
	echo "<br>";
	echo "<br>";

	echo "<center><span class='style1'>Este circuito j&aacute; se encontra cadastro, no entanto em outro dia.</span></center>
	<center><span class='style1'><br>Inserir <u>$_GET[filial]</u> <u>$_GET[ccto]</u> na base de dados.<p> <input type='button' onclick='submitor()' value='Inserir Circuito'></p></span></center>";
	}
}
else {

	echo "<script>";
	echo "window.parent.l_vel.style.display = \"block\";";
	echo "window.parent.l_com.style.display = \"block\";";
	echo "window.parent.l_pen.style.display = \"block\";";
	echo "window.parent.l_data.style.display = \"block\";";
	echo "</script>";
	echo "<br>";
	echo "<br>";
	echo "<center><span class='style1'>N&atilde;o existe $_GET[filial] $_GET[ccto] na base de dados.<br><br> <input type='button' onclick='submitor()' value='Inserir Circuito'></span></center>

		<script>
		window.parent.check.disabled = 0;
		</script>";

	
}
?>
</body>
</html>
