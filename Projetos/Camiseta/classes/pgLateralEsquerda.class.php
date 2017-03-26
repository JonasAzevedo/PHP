<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: pgLateralEsquerda.class.php
  Função: página da lateral esquerda
  Data de Criação: 08/02/2011 - 16:00
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
  CriarDivBuscarProduto() //cria a div de busca por produtos
  CriarDivMenuNavegacao() //cria a div do menu de navegação
  CriarDivFacaSuaCamiseta() //cria a div para o usuário criar a sua camiseta
  FecharDivPrincipal()
  FecharBody()
  FecharHTML()
-->

<?php
    class LateralEsquerda{
	  function __construct(){
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->IniciarDivPrincipal();
        $this->CriarDivBuscarProduto();
        $this->CriarDivMenuNavegacao();
        $this->CriarDivFacaSuaCamiseta();
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
          echo "<link rel='stylesheet' href='./css/cPgLateralEsquerda.class.css' type='text/css' />";
        echo "</head>";
      }

      //iniciar tag body
      private function IniciarBody(){
        echo "<body>";
      }

      //inicia a div principal do site
      private function IniciarDivPrincipal(){
        echo "<div class='divLateralEsquerda' name='divLateralEsquerda' id='divLateralEsquerda'>";
      }
      
      //cria a div de busca por produtos
      private function CriarDivBuscarProduto(){
        echo "<div class='divLatEsqBuscaProdutos' name='divLatEsqBuscaProdutos' id='divLatEsqBuscaProdutos'>";
          require_once(".\paginas\pgPesquisarProdutos.php");
          $this->pgPesquisarProdutos = new PgPesquisarProdutos();
        echo "</div>";
      }

      //cria a div do menu de navegação
      private function CriarDivMenuNavegacao(){
        echo "<div class='divLatEsqMenuNavegacao' name='divLatEsqMenuNavegacao' id='divLatEsqMenuNavegacao'>";
          require_once(".\paginas\pgMenuNavegacao.php");
          $this->pgMenuNavegacao = new PgMenuNavegacao();
        echo "</div>";
      }
      
      //cria a div para o usuário criar a sua camiseta
      private function CriarDivFacaSuaCamiseta(){
      //  pendente. Deixar para outra versão.
      //  echo "<div class='divLatEsqFacaSuaCamiseta' name='divLatEsqFacaSuaCamiseta' id='divLatEsqFacaSuaCamiseta'>";
      //    echo "faça sua camiseta";
      //  echo "</div>";
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
    } //fim - class LateralEsquerda
?>
