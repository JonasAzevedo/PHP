<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: layout.class.php
  Fun��o: layout do site - uni as demais p�ginas e forma o layout
  Data de Cria��o: 08/02/2011 - 14:09
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
  Acessando p�gina: -
--------------------------------------------------------------------
------------------------------------------------------------------->

<!--
//function's:
  IncluirClasses() //inclui as classes necess�rias para o layout do site
  InicializarVariaveis() //iniciar vari�veis/objetos
-->

<?php
    class Layout {
      function __construct(){
        $this->IncluirClasses();
        $this->InicializarVariaveis();
      }

      //inclui as classes necess�rias para o layout do site
      private function IncluirClasses(){
        include_once(".\classes\pgCabecalho.class.php");
        include_once(".\classes\pgLateralEsquerda.class.php");
        include_once(".\classes\pgConteudo.class.php");
      }

      //iniciar vari�veis/objetos
      private function InicializarVariaveis(){
        $this->cabecalho = new Cabecalho();
        $this->lateralEsquerda = new LateralEsquerda();
        $this->conteudo = new Conteudo();
      }
    } //fim - class Layout
?>
