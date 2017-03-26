<?php
/*******************************************************************
********************************************************************
  Nome: pgConteudo.class.php
  Fun��o: p�gina do conte�do
  Data de Cria��o: 08/02/2011 - 15:15
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
  Acessando p�gina: -
********************************************************************
*******************************************************************/

/*
//function's:
  SolicitarArquivos()
  InicializarVariaveis()
  IniciarHTML()
  IniciarBody()
  IniciarDivPrincipal()
  CriarDivContProdutos() //cria a div de conte�do dos produtos
  CriarDivContNavegacao() //cria a div de navega��o
  CriarDivDestaque() //cria a div de destaque
  FecharDivPrincipal()
  FecharBody()
  FecharHTML()
*/
    class Conteudo{
      //m�todos gerais
      private $FMetGer;
    
      function __construct(){
        $this->SolicitarArquivos();
        $this->InicializarVariaveis();
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->IniciarDivPrincipal();
        $this->CriarDivContProdutos();
        $this->CriarDivContNavegacao();
        $this->CriarDivDestaque();
        $this->FecharDivPrincipal();
        $this->FecharBody();
        $this->FecharHTML();
      }

      
	  //solicita arquivos necess�rios desta p�gina
	  private function SolicitarArquivos(){
        require_once("metodosGerais.php");
	  }
	  
	  
	  private function InicializarVariaveis(){
        //m�todos gerais
        $this->FMetGer = MetodosGerais::GetInstanciaMetodosGerais();
	  }


      //inicia HTML
      function IniciarHTML(){
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
	    echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
	    echo "<head>";
	      echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />";
          echo "<link rel='stylesheet' href='./css/cPgConteudo.class.css' type='text/css' />";
          
          echo "<script language='JavaScript' src='./js/jGeral.js'></script>";
          echo "<script language='JavaScript' src='./js/numberFormat154.js'></script>";
          //echo "<script type='text/javascript' src='./jQuery/js/jquery-1.4.4.min.js'></script>";
          //plugin para arredondar bordar das div's
          echo "<script type='text/javascript' src='./jQuery/plugin/jCornerDemo.js'></script>";
          echo "<script language='JavaScript' src='./js/jQryPgConteudo.js'></script>";
        echo "</head>";
      }


      //iniciar a tag body
      function IniciarBody(){
        echo "<body>";
        echo "1";
      }

      //inicia a div principal do site
      function IniciarDivPrincipal(){
        echo "<div class='divConteudo' name='divConteudo' id='divConteudo'>";
      }

      //cria a div de conte�do dos produtos
      function CriarDivContProdutos(){
        echo "<div class='divContProdutos' name='divContProdutos' id='divContProdutos'>";
          require_once(".\paginas\pgProdutos.php");
          $this->pgProdutos = new PgProdutos();
        echo "</div>";
      }

      //cria a div de navega��o
      function CriarDivContNavegacao(){
        echo "<div class='divContNavegacao' name='divContNavegacao' id='divContNavegacao'>";
          require_once(".\paginas\pgNavegacao.php");
          $this->pgNavegacao = new PgNavegacao();
        echo "</div>";
      }
      
      
      //cria a div de destaque
      private function CriarDivDestaque(){
        //a div de destaque s� ser� exibida:
        //  -> quando a p�gina for aberta, ou
        //  -> se o usu�rio acessou a p�gina a mais de quinze minutos.
        if (($_SESSION["sUsuarioLogou"] != "sim") || ($this->FMetGer->DiferencaEntreDatas($_SESSION["dDataAtualizou"],date('d/m/Y H:i:s'),"m") > 15)) {
          echo "<div class='divContDestaque' name='divContDestaque' id='divContDestaque'>";
            echo "<div class='divLinkFecharDestaque' name='divLinkFecharDestaque' id='divLinkFecharDestaque'>";
              echo "<a href='' class='aLnkFechar' name='aLnkFecharDestaque' id='aLnkFecharDestaque'>Fechar</a>";
            echo "</div>";
            echo "<div class='divConteudoDestaque' name='divConteudoDestaque' id='divConteudoDestaque'>";
              require_once(".\paginas\pgDivDestaque.php");
              $this->pgDivDestaque = new PgDivDestaque();
            echo "</div>";
          echo "</div>";
        }
      } //fim - CriarDivDestaque()


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
    } //fim - class Conteudo
?>
