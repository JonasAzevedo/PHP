<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: pgDivDestaque.php
  Fun��o: p�gina que apresenta a div de destaque
  Data de Cria��o: 27/03/2011 - 19:25
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
  Acessando p�gina: -
--------------------------------------------------------------------
------------------------------------------------------------------->

<!--
//function's:
  IniciarHTML()
  IniciarBody()
  IniciarDivPrincipal()
  CriarDivContProdutos() //cria a div de conte�do dos produtos
  CriarDivContNavegacao() //cria a div de navega��o
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
