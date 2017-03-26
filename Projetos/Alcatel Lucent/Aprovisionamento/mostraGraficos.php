<?php
  /* gráficos disponíveis
  Jonas da Silva Azevedo
  Criado: 26/01/2010 - 21:09
*/
  require("sessao.php");
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <link rel="stylesheet" type="text/css" href="estilos.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Gráficos de OS's Encerradas</title>
  </head>

  <frameset cols="20%,80%" framespacing="1">
    <frame src="menuMostraGraficos.php" name="frmMenu" noresize>
    <frame src="exibeGrafico.php" name="frmGrafico"  noresize>
  </frameset>

</html>
