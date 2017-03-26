<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: pgNavegacao.php
  Função: página de navegação - irá ter os links entre as página
  Data de Criação: 11/02/2011 - 08:38
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: -
--------------------------------------------------------------------
------------------------------------------------------------------->

<!--
//function's:
  IniciarHTML()
  IniciarBody()
  IniciarDivPrincipal()
  CriarLinks()  //cria os link's para navegação entre a páginas/produtos do site
  FecharDivPrincipal()
  FecharBody()
  FecharHTML()
-->

<?php
    class PgNavegacao{
      function __construct(){
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->IniciarDivPrincipal();
        $this->CriarLinks();
        $this->FecharDivPrincipal();
        $this->FecharBody();
        $this->FecharHTML();
      }
      
      
      //inicia HTML
      function IniciarHTML(){
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
	    echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
	    echo "<head>";
	      echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />";
          echo "<link rel='stylesheet' href='./css/cPgNavegacao.css' type='text/css' />";
          echo "<script language='JavaScript' src='./js/jPgNavegacao.js'></script>";
        echo "</head>";
      }
      
      
      //iniciar a tag body
      function IniciarBody(){
        echo "<body>";
      }
      

      //inicia a div principal do site
      function IniciarDivPrincipal(){
        echo "<div class='divNavegacao' name='divNavegacao' id='divNavegacao'>";
      }
      
      
      //cria os link's para navegação entre a páginas/produtos do site
      function CriarLinks(){
       //div que agregará as demais div's dos link's
       echo "<div class='divAgregaDivsNavegacao' name='divAgregaDivsNavegacao' id='divAgregaDivsNavegacao'>";
         echo "<div class='divLinkNavegacao' name='divLinkNavegacao1' id='divLinkNavegacao1'>";
           echo "<a href='javascript: SelecionandoLinkPagina(1,lnkPg1.text);' class='lnkPg' name='lnkPg1' id='lnkPg1'>0</a>";
         echo "</div>";

         echo "<div class='divLinkNavegacao' name='divLinkNavegacao2' id='divLinkNavegacao2'>";
           echo "<a href='javascript: SelecionandoLinkPagina(2,lnkPg2.text);' class='lnkPg' name='lnkPg2' id='lnkPg2'>1</a>";
         echo "</div>";

         echo "<div class='divLinkNavegacao' name='divLinkNavegacao3' id='divLinkNavegacao3'>";
           echo "<a href='javascript: SelecionandoLinkPagina(3,lnkPg3.text);' class='lnkPg' name='lnkPg3' id='lnkPg3'>2</a>";
         echo "</div>";

         echo "<div class='divLinkNavegacao' name='divLinkNavegacao4' id='divLinkNavegacao4'>";
           echo "<a href='javascript: SelecionandoLinkPagina(4,lnkPg4.text);' class='lnkPg' name='lnkPg4' id='lnkPg4'>3</a>";
         echo "</div>";

         echo "<div class='divLinkNavegacao' name='divLinkNavegacao5' id='divLinkNavegacao5'>";
           echo "<a href='javascript: SelecionandoLinkPagina(5,lnkPg5.text);' class='lnkPg' name='lnkPg5' id='lnkPg5'>4</a>";
         echo "</div>";
       echo "</div>"; //fim - div divAgregaDivsNavegacao
      } //fim - CriarLinks()
      
      
      //finaliza a div principal
      function FecharDivPrincipal(){
        echo "</div>";
      }


      //finaliza a tag body
      function FecharBody(){
        echo "</body>";
      }
      

      //finaliza HTML
      function FecharHTML(){
        echo "</html>";
      }
      
    } //fim - class PgNavegacao
?>
