<?php

include("funcoes.php");

conectar();

if($_GET['mod'] == 'inserir') {

if(!isset($_POST['data_e'])){
$_POST['data_e'] = "";
}

if($_POST['data_e'] == null || $_POST['data_e'] == '') {
$hoje = hoje();
}
else {
return; //verificar se está dentro dos 3 dias permitidos
}

if(ver_tam($_POST['t_circuito'],7) == false) {
return; //redirecionar para erro.php mensagem de erro
}

if($_POST['t_filial'] == null || $_POST['t_filial'] == '' || $_POST['t_filial'] == '#') {
return; //erro de não selecionada a filial
}

if($_POST['t_velocidade'] == null || $_POST['t_filial'] == '') {
return; //erro de selecionar uma velocidade
}
else {
	if($_POST['t_velocidade'] == 'E1') {
	$tipo = 'E1';
	}
	else {
	$tipo = 'FE';
	}
}



$query = mysql_query("INSERT INTO `tabelacptx`(`tr`,`filial`,`circuito`,`velocidade`,`tipo`,`data_e`) VALUES('$_SESSION[log_tx]','$_POST[t_filial]','$_POST[t_circuito]','$_POST[t_velocidade]','$tipo','$hoje')");
ver_mysql($query);
inserir_comentario($_POST['t_circuito'],$_POST['t_filial'],$_POST['t_comentario']);



echo "
<script language=\"javascript\">
location.href=\"confirmacao.html\"
</script>";

}

exit;

if($_GET['mod'] == 'e1') {

$vetor[0] = $_POST ['filial']; 
$vetor[1] = $_POST ['circuitos'];

$parar = false;

//Verificando se há algum campo nulo...
	for($x=0; $x<2; $x++) {
		if($vetor[$x] == null) {
		$parar = true;
		}
	}

	if($parar == true) {
		echo "<script language=\"javascript\">
		location.href=\"registro.php?error=1\"
		</script>";
		exit;
	}

//cctos

$cctos = explode("\n", $_POST['circuitos']);

$datem = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));
$datem1 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$datem2 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-2,date("Y")));
$datem3 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-3,date("Y")));

//data_e
$error = true;

	if(!isset($_POST['data_e']) || $_POST['data_e'] == '') {
		$data_e = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));	
	}
	else {
		list($dia,$mes,$ano) = explode("-", $_POST['data_e']);
		$data_e = $ano . "-" . $mes . "-" . $dia;
	}

	if($datem == $data_e) {
		$data_e = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));
		$error = false;
	}

	if ($datem1 == $data_e) {
		$date_e = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
		$error = false;
	}

	if($datem2 == $data_e) {
		$data_e = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-2,date("Y")));
		$error = false;
	}

	if($datem3 == $data_e) {
		$date_e = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-3,date("Y")));
		$error = false;
	}

	if($error == true) {
		echo "
		<script language=\"javascript\">
		location.href=\"error.php?error=1\"
		</script>";
		exit;
	}

list($cp,$filial) = explode("/",$_POST['filial' ]);


	foreach ($cctos as $ccto) {
	$ccto = trim($ccto);
		if(strlen($ccto) != 7) {
		echo "
		<script language=\"javascript\">
		location.href=\"error.php?error=2\"
		</script>";
		exit;
		}
		$query = mysql_query("SELECT* from `tabelacptx` WHERE `circuito` like '$ccto' and `filial` like '$cp'");
		if(mysql_num_rows($query) != 0) {
		echo "
		<script language=\"javascript\">
		location.href=\"error.php?error=3&fil=$cp&circ=$ccto\"
		</script>";
		exit;
		}
		$query = mysql_query("INSERT INTO `tabelacptx`(`tr`,`circuito`,`data_e`,`tipo`,`velocidade`,`filial`) VALUES('$_SESSION[log_tx]','$ccto','$data_e','E1','2048','$cp')");
		if(!$query) {
			echo mysql_error();
			exit;
		}
	}
echo "
<script language=\"javascript\">
location.href=\"confirmacao.html\"
</script>";
}

if($_GET['mod'] == 'fe') {

$datem = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));
$datem1 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$datem2 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-2,date("Y")));
$datem3 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-3,date("Y")));

//data_e
$error = true;

	if(!isset($_POST['data_e1']) || $_POST['data_e1'] == '') {
		$data_e = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));
	}
	else {
		list($dia,$mes,$ano) = explode("-", $_POST['data_e1']);
		$data_e = $ano . "-" . $mes . "-" . $dia;
	}

	if($datem == $data_e) {
		$data_e = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));
		$error = false;
	}

	if ($datem1 == $data_e) {
		$date_e = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
		$error = false;
	}

	if($datem2 == $data_e) {
		$data_e = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-2,date("Y")));
		$error = false;
	}

	if($datem3 == $data_e) {
		$date_e = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-3,date("Y")));
		$error = false;
	}

	if($error == true) {
		
		echo "
		<script language=\"javascript\">
		location.href=\"error.php?error=1\"
		</script>";
		exit;
	}

$parar = false;

$z=0;
	for($x=1;$x<5;$x++) {
	$circ = "circ" . $x;
	$vel = "vel" . $x;
	$fil = "fil" . $x;
	list($cp,$est) = explode("/", $_POST[$fil]);
		if(!isset($_POST[$circ]) || $_POST[$circ] == '') {
		$_POST[$circ] = null;
		}
		else {
			if(strlen($_POST[$circ]) != 7) {
			$parar = true;
			}
			else {
			$circuito[$z] = $_POST[$circ];
			$velocidade[$z] = $_POST[$vel];
			$filial[$z] = $cp;
			$z++;
			}
		}
	}

$circ = null;
$tipo = "FE";

	if($parar == true) {
		echo "
		<script language=\"javascript\">
		location.href=\"error.php?error=2\"
		</script>";
	exit;
	}
for($x=0; $x<$z;$x++) {

	$query = mysql_query("SELECT* from `tabelacptx` WHERE `circuito` like '$circuito[$x]' and `filial` like '$filial[$x]'");
		if(mysql_num_rows($query) != 0) {
		echo "
		<script language=\"javascript\">
		location.href=\"error.php?error=3&fil=$filial[$x]&circ=$circuito[$x]\"
		</script>";
		exit;
		}
}
for($x=0; $x<$z;$x++) {

	$query = mysql_query("INSERT INTO `tabelacptx`(`tr`,`circuito`,`velocidade`,`tipo`,`data_e`,`filial`) VALUES('$_SESSION[log_tx]','$circuito[$x]','$velocidade[$x]','$tipo','$data_e','$filial[$x]')");
	if(!$query) {
	echo "Contate o administrador, Erro: " . mysql_error();
	exit;	
	}
}
echo "
<script language=\"javascript\">
location.href=\"confirmacao.html\"
</script>";

}
?>
