<?php
  /* Controle de Sessao
  autor: Jonas da Silva Azevedo
  criado em: 07/03/2010 - 20:56
  �ltima modifica��o:
  */

  ini_set("session.save_path","C:\wamp\www\aprovisionamento\Sessions"); //muda diret�rio que ser� salva a sess�os
  session_start();
    if ((!(session_is_registered("codigoUsuario"))) or (!(session_is_registered("nomeUsuario")))){
      header("Location: http:./login.php");
    }
?>
