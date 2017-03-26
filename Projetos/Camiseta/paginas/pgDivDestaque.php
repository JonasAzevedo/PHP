<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: pgDivDestaque.php
  Função: página que apresenta a div de destaque
  Data de Criação: 27/03/2011 - 19:25
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
  CriarDivContProdutos() //cria a div de conteúdo dos produtos
  CriarDivContNavegacao() //cria a div de navegação
  FecharDivPrincipal()
  FecharBody()
  FecharHTML()
-->

<?php
    class PgDivDestaque{
      function __construct(){
        $this->SelecionarConteudoDestaque();
        $this->ApresentarConteudoDestaque();
      }


      private function SelecionarConteudoDestaque(){

      }
      
      private function ApresentarConteudoDestaque(){
        echo "<div class='divContProdutos' name='divContProdutos' id='divContProdutos'>";
             echo 'h';
        echo "</div>";
      }


    } //fim - class PgDivDestaque
?>
