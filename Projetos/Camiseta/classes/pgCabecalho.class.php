<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: pgCabecalho.class.php
  Função: página do cabeçalho
  Data de Criação: 08/02/2011 - 14:11
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
  CriarDivApresentacaoSite() //cria a div de apresentação do site
  CriarDivProdutosDestaque() //cria a div de produtos em destaque
  CriarDivLoginIdentificacaoUsuario() //cria a div de login/identificação do usuário
  FecharDivPrincipal()
  FecharBody()
  FecharHTML()
-->

<?php
    class Cabecalho{
	  function __construct(){
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->IniciarDivPrincipal();
        $this->CriarDivApresentacaoSite();
        $this->CriarDivProdutosDestaque();
        $this->CriarDivLoginIdentificacaoUsuario();
        $this->FecharDivPrincipal();
        $this->FecharBody();
        $this->FecharHTML();
      }

      //inicia HTML
      private function IniciarHTML(){
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
	    echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
	    echo "<head>";
	      echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />";
          echo "<link rel='stylesheet' href='./css/cPgCabecalho.class.css' type='text/css' />";
          echo "<script type='text/javascript' src='./jQuery/js/jquery-1.4.4.min.js'></script>";
        echo "</head>";
      }

      //iniciar a tag body
      private function IniciarBody(){
        echo "<body>";
      }

      //inicia a div principal do site
      private function IniciarDivPrincipal(){
        echo "<div class='divCabecalho' name='divCabecalho' id='divCabecalho'>";
      }

      //cria a div de apresentação do site
      private function CriarDivApresentacaoSite(){
        echo "<div class='divCabApresentacaoSite' name='divCabApresentacaoSite' id='divCabApresentacaoSite'>";
          echo 'incluir pagina de apresentaçao do <br> site';
        echo "</div>";
      }

      //cria a div de produtos em destaque
      private function CriarDivProdutosDestaque(){
        echo "<div class='divCabProdutosDestaque' name='divCabProdutosDestaque' id='divCabProdutosDestaque'>";
          require_once(".\paginas\pgProdutosDestaque.php");
          $this->pgProdutosDestaque = new PgProdutosDestaque();
        echo "</div>";
      }


      //cria a div de login/identificação do usuário
      private function CriarDivLoginIdentificacaoUsuario(){
        echo "<div class='divCabLoginIdentificacaoUsuario' name='divCabLoginIdentificacaoUsuario' id='divCabLoginIdentificacaoUsuario'>";
          require_once(".\paginas\pgIdentificacaoUsuario.php");
          $this->pgIdentificacaoUsuario = new PgIdentificacaoUsuario();
        echo "</div>";
      }

      //finaliza a div principal
      private function FecharDivPrincipal(){
        echo "</div>";
      }

      //finaliza a tag body
      private function FecharBody(){
        echo "</body>";
      }

      //finaliza HTML
      private function FecharHTML(){
        echo "</html>";
      }
    } //fim - class Cabecalho
?>
