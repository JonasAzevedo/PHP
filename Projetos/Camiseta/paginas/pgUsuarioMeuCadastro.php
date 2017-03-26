<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: pgUsuarioMeuCadastro.php
  Função: página do usuário, com os dados de cadastro deste
  Data de Criação: 10/03/2011 - 08:07
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: http://localhost/VENDA_CAMISETA/paginas/pgUsuarioMeuCadastro.php
--------------------------------------------------------------------
------------------------------------------------------------------->

<!--
//function's:
  IniciarHTML()
  IniciarBody()
  IniciarDivPrincipal()
  CriarDivMeuCadastroCabecalho()  //cria a div de cabeçalho
  CriarDivMeuCadastroLateralEsquerda() //cria a div da lateral esquerda
  CriarDivMeuCadastroConteudo() //cria a div do conteúdo
  FecharDivPrincipal()
  FecharBody()
  FecharHTML()
-->

<?php
    $pgMeuCadastro = new PgMeuCadastro();

    class PgMeuCadastro{
      function __construct(){
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->IniciarDivPrincipal();
        $this->CriarDivMeuCadastroCabecalho();
        $this->CriarDivMeuCadastroLateralEsquerda();
        $this->CriarDivMeuCadastroConteudo();
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
          echo "<link rel='stylesheet' href='../css/cPgUsuarioMeuCadastro.css' type='text/css' />";
          echo "<script type='text/javascript' src='../js/jPgUsuarioMeuCadastro.js'></script>";
        echo "</head>";
      }


      //iniciar a tag body
      private function IniciarBody(){
        echo "<body>";
      }


      //inicia a div principal do site
      private function IniciarDivPrincipal(){
        echo "<div class='divMeuCadastro' name='divMeuCadastro' id='divMeuCadastro'>";
      }


      //cria a div de cabeçalho
      private function CriarDivMeuCadastroCabecalho(){
        echo "<div class='divMeuCadastroCabecalho' name='divMeuCadastroCabecalho' id='divMeuCadastroCabecalho'>";
          echo "div do cabeçalho";
        echo "</div>";
      }
      
      
      //cria a div da lateral esquerda
      private function CriarDivMeuCadastroLateralEsquerda(){
        echo "<div class='divMeuCadastroLateralEsquerda' name='divMeuCadastroLateralEsquerda' id='divMeuCadastroLateralEsquerda'>";
          echo "<div class='divLatEsqMeuCadastro' name='divLatEsqMeuCadastro' id='divLatEsqMeuCadastro'>";
            echo "Meus dados";
            echo "Ver www.carrefour.com.br";
          echo "</div>";
          
          echo "<div class='divLatEsqPedidos' name='divLatEsqPedidos' id='divLatEsqPedidos'>";
            echo "Acompanhe seu Pedido";
            echo "<BR>";
            echo "Pedidos em Aberto";
            echo "<BR>";
            echo "Pedidos Finalizados";
            echo "<BR>";
          echo "</div>";
          
          echo "<div class='divLatEsqServicos' name='divLatEsqServicos' id='divLatEsqServicos'>";
            echo "Vale Troca";
          echo "</div>";
          
          echo "<div class='divLatEsqAvaliacoes' name='divLatEsqAvaliacoes' id='divLatEsqAvaliacoes'>";
            echo "Meu Comentários";
          echo "</div>";
          
        echo "</div>";
      } //fim - CriarDivMeuCadastroLateralEsquerda()
      
      
      //cria a div do conteúdo
      private function CriarDivMeuCadastroConteudo(){
        echo "<div class='divMeuCadastroConteudo' name='divMeuCadastroConteudo' id='divMeuCadastroConteudo'>";
          echo "div do meu conteudo";
        echo "</div>";
      } //fim - CriarDivMeuCadastroConteudo()


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

    } //fim - class PgMeuCadastro
?>
