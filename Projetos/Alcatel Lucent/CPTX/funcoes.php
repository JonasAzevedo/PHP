<?php

session_start();

function logout() {

	if(!isset($_SESSION['log_tx'])) {
			echo "<script>";
			echo	"document.location.href = 'login.php'";
			echo "</script>";
	}

}

function setado($var){

if(!isset($var)){
$var = null;
}

return;
}

function conectar() {

$con = mysql_connect($_SESSION['db_endereco'],$_SESSION['db_user'],$_SESSION['db_senha']);
mysql_select_db($_SESSION['db_base'],$con);


	if(!$con) {
	echo mysql_error();
	echo "Não foi possivel estabelecer uma conexao";
	exit;
	return;
	}
	return $con;
}

function ver_mysql($valor) {

	if(!$valor) {
	echo mysql_error();
	exit;
	return;
	}

}

function num_mes($mes) {

	switch($mes) {
		case 1:
		return "Janeiro";
		break;

		case 2:
		return "Fevereiro";
		break;

		case 3:
		return "Mar&ccedil;o";
		break;

		case 4:
		return "Abril";
		break;

		case 5:
		return "Maio";
		break;

		case 6:
		return "Junho";
		break;

		case 7:
		return "Julho";
		break;

		case 8:
		return "Agosto";
		break;

		case 9:
		return "Setembro";
		break;

		case 10:
		return "Outubro";
		break;

		case 11:
		return "Novembro";
		break;

		case 12:
		return "Dezembro";
		break;
	}

}


function verificar_circ($filial,$ccto) {

$con = mysql_connect($_SESSION['db_endereco'],$_SESSION['db_user'],$_SESSION['db_senha']);
mysql_select_db($_SESSION['db_base'],$con);


	if(!$con) {
	echo mysql_error();
	exit;
	return;
	}

$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `filial` =  '$filial' and `circuito` = '$ccto'");

mysql_close($con);

	if(!$query) {
	echo mysql_error();
	exit;
	return;
	}

	if(mysql_num_rows($query) > 0) {
	return true;
	}
	else {
	return false;
	}

}

function ver_com($filial,$ccto) {
$con = conectar();
	if(!$con) {
	echo mysql_error();
	exit;
	return;
	}
$query = mysql_query("SELECT* FROM `comentarios` WHERE `filial` =  '$filial' and `n_circ` = '$ccto'");
mysql_close($con);
	if(!$query) {
	echo mysql_error();
	exit;
	return;
	}
	if(mysql_num_rows($query) > 0) {
	return true;
	}
	else {
	return false;
	}
}

function ver_obj($filial,$ccto) {
$con = conectar();
	if(!$con) {
	echo mysql_error();
	exit;
	return;
	}
$query = mysql_query("SELECT* FROM `objectel` WHERE `filial` =  '$filial' and `n_circ` = '$ccto'");
mysql_close($con);
	if(!$query) {
	echo mysql_error();
	exit;
	return;
	}
	if(mysql_num_rows($query) > 0) {
	return true;
	}
	else {
	return false;
	}
}

function ver_obj_at($filial,$ccto) {
$con = conectar();
	if(!$con) {
	echo mysql_error();
	exit;
	return;
	}
$query = mysql_query("SELECT* FROM `objectel` WHERE `filial` =  '$filial' and `n_circ` = '$ccto' and `status` = 0");
mysql_close($con);
	if(!$query) {
	echo mysql_error();
	exit;
	return;
	}
	if(mysql_num_rows($query) > 0) {
	return true;
	}
	else {
	return false;
	}
}

function ver_pen($filial,$ccto) {
$con = conectar();
	if(!$con) {
	echo mysql_error();
	exit;
	return;
	}
$query = mysql_query("SELECT* FROM `pendencias` WHERE `filial` =  '$filial' and `n_circ` = '$ccto'");
mysql_close($con);
	if(!$query) {
	echo mysql_error();
	exit;
	return;
	}
	if(mysql_num_rows($query) > 0) {
	return true;
	}
	else {
	return false;
	}
}

function ver_pen_at($filial,$ccto) {
$con = conectar();
	if(!$con) {
	echo mysql_error();
	exit;
	return;
	}
$query = mysql_query("SELECT* FROM `pendencias` WHERE `filial` =  '$filial' and `n_circ` = '$ccto' and `status` = 0");
mysql_close($con);
	if(!$query) {
	echo mysql_error();
	exit;
	return;
	}
	if(mysql_num_rows($query) > 0) {
	return true;
	}
	else {
	return false;
	}
}


function verificar_circ_dia($filial,$ccto) {

$con = mysql_connect($_SESSION['db_endereco'],$_SESSION['db_user'],$_SESSION['db_senha']);
mysql_select_db($_SESSION['db_base'],$con);


	if(!$con) {
	echo mysql_error();
	exit;
	return;
	}
$hoje = hoje();
$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `filial` =  '$filial' and `circuito` = '$ccto' and `data_e` = '$hoje'");

mysql_close($con);

	if(!$query) {
	echo mysql_error();
	exit;
	return;
	}

	return mysql_num_rows($query);

}

function ver_tam($string,$tam){

	if(strlen($string) != $tam) {
	return false;
	}
	else{
	return true;
	}

}

function inserir_comentario($ccto,$filial,$comentario,$hoje) {


//verificando integridade da mensagem

$con = conectar();

$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `circuito` = '$ccto' and `filial` = '$filial'");
ver_mysql($query);

while($row = mysql_fetch_array($query)) {
	$n = $row['n'];
}

mysql_free_result($query);

$query = mysql_query("INSERT INTO `comentarios`(`n_circ`,`filial`,`tr`,`data_c`,`comentario`) VALUES('$ccto','$filial','$_SESSION[log_tx]','$hoje','$comentario')");
ver_mysql($query);

mysql_close($con);

return;

}

function hoje() {

$ano = date('Y');
$mes = date('m');
$dia = date('d');

$hoje = "$ano-$mes-$dia";

return $hoje;
}

function tr_nome($tr){

$tr = strtoupper($tr);

$con = conectar();

$query = mysql_query("SELECT* FROM `cadastro` where `tr` = '$tr'");
if(mysql_num_rows($query) != 1) {
echo "ERRO: Retornado: " . mysql_num_rows($query);
}

ver_mysql($query);

	while($row = mysql_fetch_array($query)) {
	$nome = $row['nome'];
	}

return $nome;

mysql_close($con);

}

function AutenticarSenha($senha) {

$con = conectar();

$query = mysql_query("SELECT* FROM `cadastro` WHERE `senha` = '$senha' and `tr` = '$_SESSION[log_tx]'");
ver_mysql($query);
$nlinha = mysql_num_rows($query);

	if($nlinha != 1) {

	return false;
	}
	else {
	return true;
	}
}



function org_data($data){

if($data == null) {
return hoje();
}


list($dia,$mes,$ano) = explode("-",$data);
return $ano."-".$mes."-".$dia;
}

function ver_data($data,$range) {
$data = org_data($data);
for($x = 0; $x < $range+1; $x++) {
$datem = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-$x,date("Y")));
	if($data == $datem) {
	$data = $datem;
	return $data;
	}
}
return false;
}

function VerNulo($par) {
	if($par == '' or $par == null) {
	return true;
	}
	else {
	return false;
	}
}

function inserir_pendencias($ccto,$fil,$tr,$data,$pend,$pendc) {
if($data == null) {
echo "Não há data!";
exit;
}
$con = conectar();

$query = mysql_query("INSERT INTO `pendencias`(`n_circ`,`filial`,`tr`,`data_e`,`pendencia`,`relatorio`) 
							VALUES('$ccto', '$fil', '$tr', '$data', '$pend','$pendc')");
ver_mysql($query);

mysql_close($con);

return;
}

function inserir_circuito($tr,$filial,$ccto,$velocidade,$data,$obs) {

  $con = conectar();

  $query = mysql_query("INSERT INTO tabelacptx(tr,filial,circuito,velocidade,data_e,observacao) VALUES('$tr','$filial','$ccto','$velocidade','$data','$obs')");
  ver_mysql($query);
  mysql_close($con);

}

function inserir_objectel($filial,$ccto,$tr,$data,$status,$relatorio) {

$con = conectar();

$query = mysql_query("INSERT INTO `objectel`(`n_circ`,`filial`,`tr`,`data_e`,`status`,`relatorio`) VALUES('$ccto','$filial','$tr','$data','$status','$relatorio')");

ver_mysql($query);

mysql_close($con);

}

function update_pendencia($n,$rep,$tr,$data) {

$con = conectar();

$query = mysql_query("UPDATE `pendencias` set `status` = 1, `replica` = '$rep',`tr_rep` = '$tr', `data_rep` = '$data' WHERE `n` = '$n'");
ver_mysql($query);


mysql_close($con);

}

function atualizar_objectel($n,$rep,$tr,$data) {

$con = conectar();

$query = mysql_query("UPDATE `objectel` set `status` = 1, `replica` = '$rep',`tr_rep`='$tr',`data_rep` = '$data' WHERE `n` = '$n'");

ver_mysql($query);

mysql_close($con);

}

function update_pen_c($filial,$ccto,$tr,$data,$com) {
	
	$con = conectar();
	$query = mysql_query("SELECT * FROM `pendencias` WHERE `n_circ` = '$ccto' and `filial` = '$filial' and `status` = 0");
	ver_mysql($query);

	if(mysql_num_rows($query) > 0) {
		while ($row = mysql_fetch_array($query)) {
		mysql_query("UPDATE `pendencias` set `status` = 1,`replica` = '$com', `tr_rep` = '$tr', `data_rep` = '$data' WHERE `n` = '$row[n]'");
		}
	}
mysql_close($con);
}

function inserir_reserva($filial,$ccto,$tr,$data) {

$con = conectar();

$query = mysql_query("INSERT INTO `reserva` (`filial`,`n_circ`,`tr`,`data_e`) VALUES('$filial','$ccto','$tr','$data')");
ver_mysql($query);

mysql_close($con);

return;
}

function liberar_reserva($filial,$ccto) {

$con = conectar();

$query = mysql_query("DELETE FROM `reserva` WHERE `n_circ` = '$ccto' and `filial` = '$filial'");
ver_mysql($query);

mysql_close($con);

}

?>

