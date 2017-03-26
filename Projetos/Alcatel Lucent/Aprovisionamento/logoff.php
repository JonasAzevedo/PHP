<?php
  /* logoff
  Jonas da Silva Azevedo
  Criado: 26/01/2010 - 10:41
*/
  require("sessao.php");
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");
  ini_set("session.save_path","C:\wamp\www\aprovisionamento\Sessions"); //muda diretório que será salva a sessãos
  session_start();
     
  echo "<center>";
  echo "<h4>";
  echo "<link rel='StyleSheet' href='estilos.css' type='text/css'/>";
  echo "<br>";
  echo "<a href='login.php'>Login</a>";
  echo "</h4>";
  echo "<br><br><br>";
  //atualizando data da saída no sistema
  $sql = "UPDATE log SET data_saida=CURRENT_TIMESTAMP WHERE codigo=" . $_SESSION['codigoLog'];
  if(!($editou = $bd->executaSQL($sql))){
    echo "Erro para realizar Logoff de " . $_SESSION['nomeUsuario'];
  }
  else {
    echo "<font face='Arial' size='6'><b>" . $_SESSION['nomeUsuario'] . " desconectado do sistema!" . "</b></font>";
    unset($_SESSION);
    session_destroy();
  }
  echo "<br>";
  echo "</center>";
?>
