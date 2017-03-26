
<?php
include("funcoes.php");

if(!isset($_GET['search'])){
$_GET['search'] = 0;
}
if(!isset($_GET['redi'])){
$_GET['redi'] = 0;
}
if(!isset($_GET['login'])){
$_GET['login'] = 0;
}
if(!isset($_GET['sair'])){
$_GET['sair'] = 0;
}
if(!isset($_GET['apagar'])){
$_GET['apagar'] = 0;
}
if(!isset($_GET['tsenha'])){
$_GET['tsenha'] = 0;
}

function stringmaker($string,$campo,$c_mysql, $cont,$x) {

if($_POST[$campo] != null) {

	if($x < 1 && $cont == 0) {
	$valor = "%" . $_POST[$campo] . "%";
	$string = $string. "`$c_mysql` like '$valor'";
	}
	elseif($x < 1 && $cont > 0) {
	$valor = "%" . $_POST[$campo] . "%";
	$string = $string. " and `$c_mysql` like '$valor'";
	}
	elseif($x == 1 && $cont == 0) {
	list($dia,$mes,$ano) = explode("-", $_POST[$campo]);
	$_POST[$campo] = $ano . "-" . $mes . "-" . $dia;
	$string = $string . "`$c_mysql` > '$_POST[$campo]'";
	}
	elseif($x == 1 && $cont > 0) {
	list($dia,$mes,$ano) = explode("-", $_POST[$campo]);
	$_POST[$campo] = $ano . "-" . $mes . "-" . $dia;
	$string = $string . " and `$c_mysql` > '$_POST[$campo]'";
	}
	elseif($x == 2 && $cont == 0) {
	list($dia,$mes,$ano) = explode("-", $_POST[$campo]);
	$_POST[$campo] = $ano . "-" . $mes . "-" . $dia;
	$string = $string . "`$c_mysql` < '$_POST[$campo]'";
	}
	elseif($x == 2 && $cont > 0) {
	list($dia,$mes,$ano) = explode("-", $_POST[$campo]);
	$_POST[$campo] = $ano . "-" . $mes . "-" . $dia;
	$string = $string . " and `$c_mysql` < '$_POST[$campo]'";
	}
}

return $string;
}

function contador($cont,$campo) {
	if($_POST[$campo] != null) {
	$cont++;
	}
return $cont;
}

if($_GET['search'] == 1) {

//Definindo campos
$matriz[0][0] = "b_ccto";
$matriz[0][1] = "circuito";

$matriz[1][0] = "data_i";
$matriz[1][1] = "data_e";

$matriz[2][0] = "data_f";
$matriz[2][1] = "data_e";

$final = '';
if($_POST['b_ccto'] == '' && $_POST['data_i'] == '' && $_POST['data_f'] == '') {
	echo "<script language='javascript'>
	location.href='consulta.php?ars=0$final'
	</script>";
}
else {
	if($_POST['b_ccto'] != '') {
	$final = $final . "&ccto=$_POST[b_ccto]";
	}

	if($_POST['data_i'] != '') {
	$final = $final . "&data_i=$_POST[data_i]";
	}

	if($_POST['data_f'] != '') {
	$final = $final . "&data_f=$_POST[data_f]";
	}
}
	echo "<script language='javascript'>
	location.href='consulta.php?ars=1$final'
	</script>";

}


if($_GET['redi'] == 1) {

	if($_POST['buscar'] == null) {
	echo "
	<script language='javascript'>
	location.href='consulta.php?ars=0'
	</script>";
	}
	else {
	echo "
	<script language='javascript'>
	location.href='consulta.php?ars=$_POST[buscar]'
	</script>";
	}

}

if($_GET['login'] == 1) {

	$con = mysql_connect("localhost","root","");
	$sec = mysql_select_db("cptx", $con);
	
	$query = mysql_query("SELECT* FROM `cadastro` WHERE `tr` like '$_POST[login]' and `senha` = '$_POST[senha]'");
	if(mysql_num_rows($query) == 1) {
	while($row = mysql_fetch_array($query)) {
	$_SESSION['log_tx'] = strtoupper($_POST['login']);
	$_SESSION['level'] = $row['level'];
	$_SESSION['db_user'] = "root";
	$_SESSION['db_senha'] = "";
	$_SESSION['db_endereco'] = "localhost";
	$_SESSION['db_base'] = 'cptx';
	}

	echo "<script language='javascript'>
	location.href='registro.php'
	</script>";
	}
	else {
	$_SESSION['log_tx'] = null;
	echo "<script language='javascript'>
	location.href='index.php?erro=1'
	</script>";
	}

}

if($_GET['tsenha'] == 1) {
	
	$ver = VerNulo($_POST['senha']);
	if($ver == true) {
	echo "<script language='javascript'>
	location.href='error.php?error=5'
	</script>";
	return;
	}

	$ver = VerNulo($_POST['nsenha']);
	if($ver == true) {
	echo "<script language='javascript'>
	location.href='error.php?error=5'
	</script>";
	return;
	}

	$ver = VerNulo($_POST['nsenha2']);
	if($ver == true) {
	echo "<script language='javascript'>
	location.href='error.php?error=5'
	</script>";
	return;
	}


	$aut = AutenticarSenha($_POST['senha']);

	if($aut == false) {
	echo "<script language='javascript'>
	location.href='error.php?error=7'
	</script>";
	return;
	}

	if($_POST['nsenha'] != $_POST['nsenha2']){
	echo "<script language='javascript'>
	location.href='error.php?error=6'
	</script>";
	return;	
	}

	$con = conectar();
	mysql_select_db("cptx", $con);

	$query = mysql_query("UPDATE `cadastro` set `senha` = '$_POST[nsenha]' WHERE `tr` = '$_SESSION[log_tx]'");	
	ver_mysql($query);
	
	mysql_close($con);

	echo "<script language='javascript'>
	location.href='confirmacao2.html'
	</script>";

}


if($_GET['apagar'] == 1) {
	$con = conectar();
	$query = mysql_query("DELETE FROM `tabelacptx` WHERE `n` = '$_GET[n]'");
	ver_mysql($query);
	mysql_close($con);
	echo "<script language='javascript'>
	top.window.consulta2.location.reload();";

	if(isset($_GET['mes']) && $_GET['mes'] != 'null') {
		echo "
		location.href='consulta3.php?mes=$_GET[mes]'";
	}
	else {
		echo "location.href='consulta3.php'";
	}
	echo "</script>";

}
else {
	if($_GET['apagar'] == 2) {
	$con = conectar();
	mysql_select_db($_SESSION['db_base'], $con);
	$query = mysql_query("DELETE FROM `comentarios` WHERE `n` = '$_GET[n]'");
	ver_mysql($query);
	mysql_close($con);
	echo "<script>location.href='historico2.php?ccto=$_GET[ccto]&filial=$_GET[filial]'</script>";

	}

}

if($_GET['sair'] == 1) {
	$_SESSION['log_tx'] = null;
	$_SESSION['level'] = null;
	$_SESSION['db_user'] = null;
	$_SESSION['db_senha'] = null;
	$_SESSION['db_endereco'] = null;
	$_SESSION['db_base'] = null;
	echo "<script language='javascript'>
	location.href='login.php'
	</script>";

}

?>
