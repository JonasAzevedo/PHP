<?php
/*
************************************************************************************************************
*
* 	CREATED ON 11/01/2010  by Jonas da Silva Azevedo
* 			CONTATO: jonassazevedo@hotmail.com
*
*  		ÚLTIMA MODIFICAÇÃO   11/01/2010 by Jonas da Silva Azevedo
*
************************************************************************************************************
* 			::::: Sistema de Gerenciamento de Rotas SDH Inviáveis :::: (Alcatel-Lucent)
************************************************************************************************************
*/
  $dbname="route";
  $usuario="root";
  $senha="";
  //conecta ao servidor MySQL
  if(!($id = mysql_connect("localhost",$usuario,$senha))) {
    echo "Não foi possível estabelecer uma conexão com o MySQL!";
    exit();
  }
  else {
  //seleciona o banco de dados
  if(!($con = mysql_select_db($dbname,$id))) {
    echo "Não foi possível estabelecer uma conexão com o MySQL!";
    exit();
  }
  }
?>
