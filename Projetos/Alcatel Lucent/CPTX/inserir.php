<?php
  include("funcoes.php");

  if($_GET['mod'] == 'inserir') {
    if($_POST['t_sobj'] == 'completo') {
	  $_POST['t_sobj'] = true;
	  $_POST['t_robj'] = 'completo';
    }
	else {
	  $_POST['t_sobj'] = false;
	}

	$con = conectar();

	if(!isset($_POST['data_e'])){
	  $_POST['data_e'] = "";
	}

	if($_POST['data_e'] == null || $_POST['data_e'] == '') {
  	  $hoje = hoje();
	}
	else {
	  $data = ver_data($_POST['data_e'],3);
	  if ($data != false) {
	  	$hoje = $data;
	  }
	  else {
	    echo"<form name='casper' id='casper' action='error.php?error=1' method='post'>
		<input type='submit' value='Retornar'></center>
		<input type='text' id='res_com1' name='res_com1' value='" . $_POST['t_comentario'] . "' style='display: none;'>
		</form>";
		echo "<script>document.casper.submit();</script>";
	  	return; //retorna o erro que a data não está nos três dias permitidos
	  }
	}

	if(ver_tam($_POST['t_circuito'],7) == false) {
	  echo "<script>location.href='error.php?error=2'</script>";
	  return; //redirecionar para erro.php mensagem de erro
	}

	if($_POST['t_filial'] == null || $_POST['t_filial'] == '' || $_POST['t_filial'] == '#') {
	  echo "<script>location.href='error.php?error=4'</script>";
	  return; //erro de não selecionada a filial
	}

	if($_POST['t_velocidade'] == null || $_POST['t_filial'] == '') {
	  echo "<script>location.href='error.php?error=2'</script>";
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
	
	$observacao = $_POST['t_observacao'];

	$query = mysql_query("INSERT INTO `tabelacptx`(`tr`,`filial`,`circuito`,`velocidade`,`tipo`,`data_e`,`s.obj`,`r.obj`,`observacao`) VALUES('$_SESSION[log_tx]','$_POST[t_filial]','$_POST[t_circuito]','$_POST[t_velocidade]','$tipo','$hoje','$_POST[t_sobj]','$_POST[t_robj]','$observacao')");
	ver_mysql($query);
	$circuito = $_POST['t_circuito'];
	$filial = $_POST['t_filial'];
	$comentario = $_POST['t_comentario'];

	mysql_close($con);

	if($comentario != '' or $comentario != null) {
      inserir_comentario($circuito,$filial,$comentario,$_POST['data_c']);
	}

	echo "
	<script language=\"javascript\">
	location.href='registro.php?ccto=" . $circuito . "&filial=" . $filial . "&inserido=1';
	</script>";
	//location.href='registro.php?ccto=" . $circuito . "&filial=" . $filial . "&inserido=1';
  } //if($_GET['mod'] == 'inserir') {

  if($_GET['mod'] == 'inscom') {
    $data = org_data($_POST['data_p']);
    inserir_comentario($_GET['ccto'],$_GET['filial'],$_POST['com'],$data);
    if(!isset($_GET['consulta'])) {
	  $_GET['consulta'] = 0;
    }

    if($_GET['consulta'] == 1) {
	  echo "
	  <script language=\"javascript\">
	  location.href='historico_c.php?ccto=" . $_GET['ccto'] . "&filial=" . $_GET['filial'] . "';
	  </script>";
    }
	else {
      echo "
	  <script language=\"javascript\">
	  location.href='historico.php?ccto=" . $_GET['ccto'] . "&filial=" . $_GET['filial'] . "';
	  </script>";
    }
  } //if($_GET['mod'] == 'inscom') {

  if($_GET['mod'] == 'aus') {
    $con = conectar();
	$hoje = hoje();
	if($_POST['ref_m'] == '' or $_POST['ref_m'] == null or $_POST['ref_m'] == $_SESSION['log_tx']) {
	  $QuemEscreveu = "'$_SESSION[log_tx]'";
      $c_justificativa = "justificativa";
	  $c_tr = "`tr`";
 	}
	else {
	  $c_justificativa = "justificativa_master";
	  $QuemEscreveu = "'$_POST[ref_m]','$_SESSION[log_tx]'";
	  $c_tr = "`tr`, `tr_master`";
	}

	if($_POST['data_un'] == null or $_POST['data_un'] == '') {
	  $query = mysql_query("INSERT INTO `ausentes`($c_tr,`data_a`,`$c_justificativa`,`de`,`ate`) VALUES($QuemEscreveu,'$hoje','$_POST[justificativa]','$_POST[data_de]','$_POST[data_ate]')");
	  ver_mysql($query);
	}
	else {
	  $query = mysql_query("INSERT INTO `ausentes`($c_tr,`data_a`,`$c_justificativa`,`diaun`) VALUES($QuemEscreveu,'$hoje','$_POST[justificativa]','$_POST[data_un]')");
	}
	ver_mysql($query);

	echo "
	  <script language=\"javascript\">
	  location.href='ausencia.php?aus=1';
	  </script>";
  } //if($_GET['mod'] == 'aus') {


	//Vem Do Histórico.php

  if($_GET['mod'] == 'insnov') {
  	$con = conectar();
	$hoje = org_data($_POST['data_p']);

	$query = mysql_query("SELECT* FROM `tabelacptx` WHERE `filial` = '$_POST[filial]' and `circuito` = '$_POST[ccto]'");
	ver_mysql($query);
	while($row = mysql_fetch_array($query)) {
  	  $velocidade = $row['velocidade'];
	  $tipo = $row['tipo'];
	  break;
	}
	
	$observacao = $_POST['t_observacao'];

	$query = mysql_query("INSERT INTO `tabelacptx`(`tr`,`filial`,`circuito`,`velocidade`,`tipo`,`data_e`,`justificativa`,`observacao`) VALUES('$_SESSION[log_tx]','$_POST[filial]','$_POST[ccto]','$velocidade','$tipo','$hoje','$_POST[just]','$observacao')");
	$_POST['just'] = "Justificativa: " . $_POST['just'];

	inserir_comentario($_POST['ccto'],$_POST['filial'],$_POST['just'],$hoje);


	echo "
      <script language=\"javascript\">
	  location.href='historico.php?ccto=" . $_POST['ccto'] . "&filial=" . $_POST['filial'] . "&ins=1';
	  </script>";
  } //if($_GET['mod'] == 'insnov') {

  if($_GET['mod'] == 'compen') {
    $data = org_data($_POST['data_e']);

	inserir_circuito($_SESSION['log_tx'],$_POST['t_filial'],$_POST['t_circuito'],$_POST['t_velocidade'],$data,$_POST['t_observacao']);
	inserir_pendencias($_POST['t_circuito'], $_POST['t_filial'], $_SESSION['log_tx'], $data, $_POST['t_cpen'],$_POST['t_pen']);
	if($_POST['t_comentario'] != '' or $_POST['t_comentario'] != null) {
	  inserir_comentario($_POST['t_circuito'],$_POST['t_filial'],$_POST['t_comentario'],$data);
	}
	echo "
	  <script language=\"javascript\">
	  location.href='registro.php?ccto=" . $circuito . "&filial=" . $filial . "&inserido=1';
	  </script>";

  } //if($_GET['mod'] == 'compen') {

  if($_GET['mod'] == 'sempen') {
    $data = org_data($_POST['data_e']);
    //Está completo
	if($_POST['t_sobj'] == 0) {
	  inserir_objectel($_POST['t_filial'], $_POST['t_circuito'], $_SESSION['log_tx'], $data, $_POST['t_sobj'], $_POST['t_robj']);
	}
	else {
	  inserir_objectel($_POST['t_filial'], $_POST['t_circuito'], $_SESSION['log_tx'], $data, $_POST['t_sobj'], "COMPLETO");
	}
    inserir_circuito($_SESSION['log_tx'],$_POST['t_filial'],$_POST['t_circuito'],$_POST['t_velocidade'],$data,$_POST['t_observacao']);
	if($_POST['t_comentario'] != '' or $_POST['t_comentario'] != null) {
	  inserir_comentario($_POST['t_circuito'],$_POST['t_filial'],$_POST['t_comentario'],$data);
	}

	echo "
	  <script language=\"javascript\">
	  location.href='registro.php?ccto=" . $circuito . "&filial=" . $filial . "&inserido=1';
	  </script>";
  } //if($_GET['mod'] == 'sempen') {

  if($_GET['mod'] == 'cpen') {
    $data = hoje();

	update_pendencia($_GET['n'],$_POST['enc'],$_SESSION['log_tx'],$data);
	inserir_objectel($_GET['filial'], $_GET['ccto'], $_SESSION['log_tx'], $data, 0, "Pendencias Resolvidas");

	echo "<script>window.opener.location.reload();
		alert(\"Pendencia atualizada com sucesso\");
		window.close();</script>";

  } //if($_GET['mod'] == 'cpen') {

  if($_GET['mod'] == 'insobj') {
    $data = hoje();

    inserir_objectel($_POST['fil'], $_POST['ccto'], $_SESSION['log_tx'], $data, $_POST['status'], $_POST['enc']);

	$con = conectar();
	$query = mysql_query("SELECT* FROM `pendencias` WHERE `n_circ` = '$_POST[ccto]' and `filial` = '$_POST[fil]' and `status` = 0");
	ver_mysql($query);

	if(mysql_num_rows($query) > 0) {
	  while ($row = mysql_fetch_array($query)) {
	    mysql_query("UPDATE `pendencias` set `status` = 1,`replica` = 'Atualizado Objectel', `tr_rep` = '$_SESSION[log_tx]', `data_rep` = '$data' WHERE `n` = '$row[n]'");
	  }
	}

	mysql_close($con);

	echo "<script>window.opener.location.reload();
	   	 alert(\"Status do Objectel atualizado com sucesso.\");
		 window.close();</script>";
  } //if($_GET['mod'] == 'insobj') {

  if($_GET['mod'] == 'atobj') {
    $data = hoje();

	atualizar_objectel($_GET['n'], $_POST['enc'],$_SESSION['log_tx'],$data);
	echo "<script>window.opener.location.reload();
		 alert(\"Status do Objectel atualizado com sucesso.\");
		 window.close();</script>";
	} //if($_GET['mod'] == 'atobj') {

  if ($_GET['mod'] == "ins_pen_sim") {
	$filial = $_POST['t_filial'];
	$ccto = $_POST['t_circuito'];
	$vel = $_POST['t_velocidade'];
	$data = org_data($_POST['t_data_e']);
	$observacao =$_POST['t_observacao'];
	$codigo = $_POST['t_codigo'];
	$parecer = $_POST['t_parecer'];

	inserir_circuito($_SESSION['log_tx'],$filial,$ccto,$vel,$data,$observacao);
	liberar_reserva($filial,$ccto);
	$con = conectar();

	$query = mysql_query("SELECT* FROM `pendencias` WHERE `n_circ` = '$ccto' and `filial` = '$filial' and `status` = 0");
	ver_mysql($query);

	if(mysql_num_rows($query) > 0) {
	  while ($row = mysql_fetch_array($query)) {
	    mysql_query("UPDATE `pendencias` set `status` = 1,`replica` = 'Migrado para: $codigo', `tr_rep` = '$_SESSION[log_tx]', `data_rep` = '$data' WHERE `n` = '$row[n]'");
      }
	  inserir_pendencias($ccto,$filial,$_SESSION['log_tx'],$data,$codigo,$parecer);
	}
	else {
	  inserir_pendencias($ccto,$filial,$_SESSION['log_tx'],$data,$codigo,$parecer);
	}
	echo "<script>window.history.back();</script>";
  } //if ($_GET['mod'] == "ins_pen_sim") {

  if ($_GET['mod'] == "ins_pen_nao_obj_sim") {
    $filial = $_POST['t_filial'];
    $ccto = $_POST['t_circuito'];
	$vel = $_POST['t_velocidade'];
    $data = org_data($_POST['t_data_e']);
	$parecer = $_POST['t_parecer'];
	$observacao = $_POST['t_observacao'];


	if(!isset($_POST['t_parecer_pen'])) {
	  $_POST['t_parecer_pen'] = "Atualizacao Automatica";
    }

	inserir_circuito($_SESSION['log_tx'],$filial,$ccto,$vel,$data,$observacao);
	update_pen_c($filial,$ccto,$_SESSION['log_tx'],$data,$_POST['t_parecer_pen']);
	liberar_reserva($filial,$ccto);
	$con = conectar();

	$query = mysql_query("SELECT * FROM `objectel` WHERE `n_circ` = '$ccto' and `filial` = '$filial' and `status` = 0");
	ver_mysql($query);

	if(mysql_num_rows($query) > 0) {
	  while ($row = mysql_fetch_array($query)) {
        mysql_query("UPDATE `objectel` set `status` = 1 WHERE `n` = '$row[n]'");
	  }
    }
	else {
	  inserir_objectel($filial, $ccto, $_SESSION['log_tx'], $data, 1, 'COMPLETO');
    }
	echo "<script>window.history.back();</script>";
  } //if ($_GET['mod'] == "ins_pen_nao_obj_sim") {

  if ($_GET['mod'] == "ins_pen_nao_obj_nao") {
    $filial = $_POST['t_filial'];
	$ccto = $_POST['t_circuito'];
	$vel = $_POST['t_velocidade'];
	$data = org_data($_POST['t_data_e']);
	$parecer = $_POST['t_parecer'];
	$observacao = $_POST['t_observacao'];

	if(!isset($_POST['t_parecer_pen'])) {
	  $_POST['t_parecer_pen'] = "Atualizacao Automatica";
	}

	inserir_circuito($_SESSION['log_tx'],$filial,$ccto,$vel,$data,$observacao);
	update_pen_c($filial,$ccto,$_SESSION['log_tx'],$data,$_POST['t_parecer_pen']);
	liberar_reserva($filial,$ccto);
	$con = conectar();

	$query = mysql_query("SELECT* FROM `objectel` WHERE `n_circ` = '$ccto' and `filial` = '$filial' and `status` = 0");
	ver_mysql($query);

	if(mysql_num_rows($query) > 0) {
	  while ($row = mysql_fetch_array($query)) {
	    mysql_query("UPDATE `objectel` set `status` = 1 WHERE `n` = '$row[n]'");
	  }
	  inserir_objectel($filial, $ccto, $_SESSION['log_tx'], $data, 0, $parecer);
	}
	else {
	inserir_objectel($filial, $ccto, $_SESSION['log_tx'], $data, 0, $parecer);
	}
	echo "<script>window.history.back();</script>";

  } //if ($_GET['mod'] == "ins_pen_nao_obj_nao") {

  if ($_GET['mod'] == "reservar") {
    $data = hoje();
	inserir_reserva($_POST['t_res_filial'],$_POST['t_res_ccto'],$_SESSION['log_tx'],$data);
	echo "<script>window.history.back();</script>";
  } //if ($_GET['mod'] == "reservar") {


?>
