<?php include("funcoes.php");
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
function submitcomment() {
	if (document.form_ic.com.value == '' || document.form_ic.com.value == null) {
	alert("Voce precisa escrever um comentario!");
	return false;
	}
	else {
	document.getElementById("data_p").disabled = false;
	document.form_ic.submit();
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
	
	echo "<br><center><div class='style3'>Hist&oacute;rico de " . $_GET['ccto'] . " </div></center>
	<br>
	<br>

	<iframe src='historico2.php?ccto=" . $_GET['ccto'] . "&filial=" . $_GET['filial'] . "' id='historico' width='100%' height='60%' frameborder='0' scrolling='auto'></iframe>

	<br><br><br>

	<form name='form_ic' id='form_ic' action='inserir.php?mod=inscom&ccto=$_GET[ccto]&filial=$_GET[filial]&consulta=1' method='post'>

	<center>
	<span class='style1'>Adicionar Coment&aacute;rio: <br><input type = 'text' id='com' name='com' size ='35' maxlength='1000'></span>
&nbsp;&nbsp;&nbsp;&nbsp;

<input type=\"text\" name=\"data_p\" id=\"data_p\" onFocus=\"this.style.background='#00FF33';\" onBlur=\"this.style.background='#ffffff';\" size='10'>

<a href=\"javascript:cal1.popup();\">
<img src=\"calendar/img/cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Clique aqui para selecionar uma data\">
</a>

<a href=\"#\"><img src=\"imagens/icon_limpar.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Apagar data\" onClick=\"document.forms['form_ic'].data_p.value=''\" /></a>


	</center>
	<br>
	<center><input type='button' value='Adicionar Comentario' onclick='submitcomment();'></center>
	<br><center><input type='button' value='fechar' onclick='window.close();'></center>

	</form><script language=\"JavaScript\">
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
	echo "<br><br><br><center><span class='style2'>N&atilde;o foi possivel encontrar este circuito na base de dados.</span><br><br><input type='button' onclick='window.close();' value='fechar'></center>";
}
?>

</body>
</html>
