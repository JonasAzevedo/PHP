<?php
/*******************************************************************
********************************************************************
  Nome: index.php
  Função: página index
  Data de Criação: 08/02/2011 - 14:06
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: -
********************************************************************
*******************************************************************/

/*
//function's:
  IniciarSession()
  GravarSession()
  IncluirClasses() //inclui as classes necessárias para iniciar site
  ConstruirIndex() //constrói a página index
*/
    $index = new Index();

    class Index {
	  function __construct(){
        $this->IniciarSession();
        echo "<div class='divIndexPrincipal' name='divIndexPrincipal' id='divIndexPrincipal'>"; //cPgConteudo.class.css
  	      $this->IncluirClasses();
	      $this->ConstruirIndex();
	    echo "</div>";
        $this->GravarSession(); //executa no final a gravação. Também controla CriarDivDestaque().
	  }
	  

   	  private function IncluirClasses(){
	    include_once(".\classes\layout.class.php");
      }


      private function ConstruirIndex(){
	    $this->layout = new Layout();
	  }
	  
	  
      //inicia a sessão que armazenará os dados do cliente
      private function IniciarSession(){
        session_start("dados_cliente");
      }


      //grava variáveis da session
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
