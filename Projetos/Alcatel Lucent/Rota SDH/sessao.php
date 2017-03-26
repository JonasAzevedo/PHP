<?php
  /* sessão
  Jonas da Silva Azevedo
  Criado: 25/01/2010 - 15:51
*/
  ini_set("session.save_path","C:\wamp\www\Rota SDH\Sessions"); //muda diretório que será salva a sessãos
  
  session_start();
  if ((!(session_is_registered("codigoUsuario"))) or (!(session_is_registered("nomeUsuario")))){
     header("Location: http://localhost/Rota%20SDH/login.php");
  }
?>

