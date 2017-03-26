<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: pgPesquisarProdutos.php
  Função: página de pesquisa por produtos
  Data de Criação: 09/02/2011 - 15:48
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
  CriarComponentesParaPesquisa()  //cria os componentes para permitir pesquisar por produtos
  FecharDivPrincipal()
  FecharBody()
  FecharHTML()
-->

<?php
    class PgPesquisarProdutos{
      function __construct(){
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->IniciarDivPrincipal();
        $this->CriarComponentesParaPesquisa();
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
          echo "<link rel='stylesheet' href='./css/cPgPesquisarProdutos.css' type='text/css' />";
          echo "<script type='text/javascript' src='./js/jPgPesquisarProdutos.js'></script>";
        echo "</head>";
      }


      //iniciar a tag body
      function IniciarBody(){
        echo "<body>";
      }
      

      //inicia a div principal do site
      function IniciarDivPrincipal(){
        echo "<div class='divPesquisarProdutos' name='divPesquisarProdutos' id='divPesquisarProdutos'>";
      }
      
      
      //cria os componentes para permitir pesquisar por produtos
      function CriarComponentesParaPesquisa(){
        echo "<span class='spnTituloPesquisar' name='spnTituloPesquisar' id='spnTituloPesquisar'>" ."Buscar: ". "</span>";
        echo "<br>";
        echo "<input type='text' class='txtValorItemPesquisa' name='txtValorItemPesquisa' id='txtValorItemPesquisa' value='' onkeyup='VerificarTecla(event);' />";
        echo "<input type='button' class='btnPesquisarProdutos' name='btnPesquisarProdutos' id='btnPesquisarProdutos' value='Pesquisar' onclick='PesquisandoProdutos();'/>";
        echo "<hr class='hrBuscar'/>";
      }
      

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
      
    } //fim - class PgPesquisarProdutos
?>
