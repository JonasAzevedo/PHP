<?php
/*
************************************************************************************************************
*
* 	CREATED ON 11/01/2010  by Jonas da Silva Azevedo
* 			CONTATO: jonassazevedo@hotmail.com
*
*  		�LTIMA MODIFICA��O   11/01/2010 by Jonas da Silva Azevedo
*
************************************************************************************************************
* 			::::: Sistema de Gerenciamento de Rotas SDH Invi�veis :::: (Alcatel-Lucent)
************************************************************************************************************
*/
  $dbname="route";
  $usuario="root";
  $senha="";
  //conecta ao servidor MySQL
  if(!($id = mysql_connect("localhost",$usuario,$senha))) {
    echo "N�o foi poss�vel estabelecer uma conex�o com o MySQL!";
    exit();
  }
  else {
  //seleciona o banco de dados
  if(!($con = mysql_select_db($dbname,$id))) {
    echo "N�o foi poss�vel estabelecer uma conex�o com o MySQL!";
    exit();
  }
  }
?>
