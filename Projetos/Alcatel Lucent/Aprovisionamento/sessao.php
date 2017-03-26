<?php
  /* sessão
  Jonas da Silva Azevedo
  Criado: 25/01/2010 - 13:57
*/
  ini_set("session.save_path","C:\wamp\www\aprovisionamento\Sessions"); //muda diretório que será salva a sessãos
  session_start();
    if ((!(session_is_registered("codigoUsuario"))) or (!(session_is_registered("nomeUsuario")))){
      //header("Location: http://10.41.95.238/aprovisionamento/login.php");
      header("Location: http://localhost/aprovisionamento/login.php");
    }
?>
