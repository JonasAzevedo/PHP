<?php
/*
************************************************************************************************************
*
* 	CREATED ON 11/01/2010  by Jonas da Silva Azevedo
* 			CONTATO: jonassazevedo@hotmail.com
*
*  		ÚLTIMA MODIFICAÇÃO   13/01/2010 by Jonas da Silva Azevedo
*
************************************************************************************************************
* 			::::: Sistema de Gerenciamento de Rotas SDH Inviáveis :::: (Alcatel-Lucent)
************************************************************************************************************
*/
     include("conecta.php");
     include("sessao.php");
     session_start();
     echo "<center>";
     echo "<h4>";
     echo "<link rel='StyleSheet' href='estilos.css' type='text/css'/>";
     echo "<br>";
     echo "<a href='login.php'>Login</a>";
     echo "</h4>";
     echo "<br><br><br>";
     echo "<font face='Arial' size='6'><b>" . $_SESSION['nomeUsuario'] . " desconectado do sistema!" . "</b></font>";
     echo "</center>";
     //atualizando data da saída no sistema
     $sql = "UPDATE log SET saida=current_timestamp WHERE codigo=" . $_SESSION['codigoLog'];
     $updateSQL = mysql_query($sql);
     unset($_SESSION);
     session_destroy();
?>
