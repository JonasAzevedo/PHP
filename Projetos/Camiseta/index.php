<?php
/*******************************************************************
********************************************************************
  Nome: index.php
  Fun��o: p�gina index
  Data de Cria��o: 08/02/2011 - 14:06
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
  Acessando p�gina: -
********************************************************************
*******************************************************************/

/*
//function's:
  IniciarSession()
  GravarSession()
  IncluirClasses() //inclui as classes necess�rias para iniciar site
  ConstruirIndex() //constr�i a p�gina index
*/
    $index = new Index();

    class Index {
	  function __construct(){
        $this->IniciarSession();
        echo "<div class='divIndexPrincipal' name='divIndexPrincipal' id='divIndexPrincipal'>"; //cPgConteudo.class.css
  	      $this->IncluirClasses();
	      $this->ConstruirIndex();
	    echo "</div>";
        $this->GravarSession(); //executa no final a grava��o. Tamb�m controla CriarDivDestaque().
	  }
	  

   	  private function IncluirClasses(){
	    include_once(".\classes\layout.class.php");
      }


      private function ConstruirIndex(){
	    $this->layout = new Layout();
	  }
	  
	  
      //inicia a sess�o que armazenar� os dados do cliente
      private function IniciarSession(){
        session_start("dados_cliente");
      }


      //grava vari�veis da session
      private function GravarSession(){
        if ($_SESSION["sUsuarioLogou"] != "sim"){
          $_SESSION["sUsuarioLogou"] = "sim";
          $_SESSION["sNavegador"] = "navegador";
          $_SESSION["sIP"] = "ip";
          $_SESSION["sMAC"] = "mac";
          $_SESSION["sResolucaoTela"] = "resolucao tela";
          $_SESSION["dData"] = date("d/m/Y H:i:s");
        }
        $_SESSION["dDataAtualizou"] = date("d/m/Y H:i:s");
      }
	  
    }
?>
