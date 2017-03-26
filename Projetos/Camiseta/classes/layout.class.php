<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: layout.class.php
  Função: layout do site - uni as demais páginas e forma o layout
  Data de Criação: 08/02/2011 - 14:09
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: -
--------------------------------------------------------------------
------------------------------------------------------------------->

<!--
//function's:
  IncluirClasses() //inclui as classes necessárias para o layout do site
  InicializarVariaveis() //iniciar variáveis/objetos
-->

<?php
    class Layout {
      function __construct(){
        $this->IncluirClasses();
        $this->InicializarVariaveis();
      }

      //inclui as classes necessárias para o layout do site
      private function IncluirClasses(){
        include_once(".\classes\pgCabecalho.class.php");
        include_once(".\classes\pgLateralEsquerda.class.php");
        include_once(".\classes\pgConteudo.class.php");
      }

      //iniciar variáveis/objetos
      private function InicializarVariaveis(){
        $this->cabecalho = new Cabecalho();
        $this->lateralEsquerda = new LateralEsquerda();
        $this->conteudo = new Conteudo();
      }
    } //fim - class Layout
?>
