<?php
  /* Controle de Sessao
  autor: Jonas da Silva Azevedo
  criado em: 07/03/2010 - 20:56
  última modificação:
  */

  ini_set("session.save_path","C:\wamp\www\aprovisionamento\Sessions"); //muda diretório que será salva a sessãos
  session_start();
    if ((!(session_is_registered("codigoUsuario"))) or (!(session_is_registered("nomeUsuario")))){
      header("Location: http:./login.php");
    }
?>
