<?php include("funcoes.php");

if(!isset($_GET['ccto']) || !isset($_GET['filial'])){
echo "Erro circuito não existe.";
exit;
}
else {
$ccto = $_GET['ccto'];
$filial = $_GET['filial'];
}

if(verificar_circ($filial,$ccto) == false) {
	echo "Circuito não existe.";
	exit;
}

if(!isset($_SESSION['log_tx'])) {
echo "<script>";
echo "alert(\"Voce precisa se autenticar no sistema para usufruir deste recurso.\");";
echo "document.location.href = 'index.php';";
echo "</script>";
exit;
}

/* Swap Modificada */
function swap(&$valor_1, &$valor_2, &$tr1 , &$tr2, &$com1, &$com2, &$tab1, &$tab2) {
	list($valor_1, $valor_2) = array($valor_2, $valor_1);
	list($tr1, $tr2) = array($tr2, $tr1);
	list($com1, $com2) = array($com2, $com1);
	list($tab1, $tab2) = array($tab2, $tab1);
}

function QualCom($int){
	switch($int) {
		case 1: $com = "Coment&aacute;rio"; break;
		case 2: $com = "Objectel"; break;
		case 3: $com = "Pend&ecirc;nciado"; break;
		default: echo "Não foi determinado o código"; exit;
	}
	return $com;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CPTX - Histórico</title>

<script>
var win = null;
function NovaJanela(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',status=0,toolbar=0,location=0,menubar=0';
	window.open(pagina,nome,settings);
}

function pend(fil,ccto) {
NovaJanela("cpend.php?ccto="+ccto+"&filial="+fil, "Pendência", '500' , '500' , "no");
}
function obj(fil,ccto) {
NovaJanela("cobj.php?ccto="+ccto+"&filial="+fil, "Pendência", '500' , '500' , "no");
}
</script>

<style type="text/css">
table.tab {
border: none;
}
table.tab th {
font-family:Arial, Helvetica, sans-serif;
font-size:16px;
}

table.tab td tr {
font-family:Arial, Helvetica, sans-serif;
font-size: 12px;
border: none;
}

table.com th {
	font-size:14px;
	border-bottom: 1px solid #000000;
}
table.com td {
	font-size:12px;
}
.pendencia {
cursor: pointer;
}

</style>

</head>

<body>
<table width="629" class="tab" height="86" align="center" border='1'>
  <tr>
    <th colspan='2' height="39" scope="col">&nbsp;</th>
  </tr>
  <tr>
    <th width="693" colspan='2' height="39" scope="col">Hist&oacute;rico -</th>
  </tr>
</table>
</body>
</html>
