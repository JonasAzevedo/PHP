<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: pgProdutos.php
  Função: página dos produtos
  Data de Criação: 09/02/2011 - 10:27
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: -
--------------------------------------------------------------------
------------------------------------------------------------------->

<!--
//function's:
  SolicitarArquivos()
  InicializarVariaveis()
  IniciarHTML()
  IniciarBody()
  IniciarDivPrincipal()
  CriarDivFiltro()
  CriarDivNenhumProduto() //cria a div que mostra a mensagem que nenhum produto foi encontrado
  CriarDivProdutos()  //constrói as div's dos produtos
  CriaDivComprarProduto() //cria a div para comprar produto
  FecharDivPrincipal()
  FecharBody()
  FecharHTML()
-->

<?php
    class PgProdutos{
      //métodos gerais
      private $FMetGer;
    
      function __construct(){
        $this->SolicitarArquivos();
        $this->InicializarVariaveis();
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->IniciarDivPrincipal();
        $this->CriarDivFiltro();
        $this->CriarDivNenhumProduto();
        $this->CriarDivProdutos();
        $this->CriaDivComprarProduto();
        $this->FecharDivPrincipal();
        $this->FecharBody();
        $this->FecharHTML();
      }
  
  
      //inicia HTML
      function IniciarHTML(){
        //echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
	    //echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
	    echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
        echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='pt-br' lang='pt-br'>";
	    echo "<head>";
	      echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />";
          echo "<link rel='stylesheet' href='./css/cPgProdutos.css' type='text/css' />";

          echo "<script language='JavaScript' src='./js/jPgProdutos.js'></script>";
          echo "<script language='JavaScript' src='./js/jSelecaoProdutos.js'></script>";
          echo "<script language='JavaScript' src='./js/jQryPgProdutos.js'></script>";
          //plugin colorBox - jQuery - (ver 'divDadosImagemProduto')
          echo "<link media='screen' rel='stylesheet' href='./css/jQuery/colorbox.css' />";
          echo "<script src='./jQuery/js/jquery.colorbox.js'></script>";
          echo "<script language='JavaScript' src='./js/jFuncoesColorBox.js'></script>";
          //arquivos para o plugin jQuery para janela modal
          echo "<link rel='stylesheet' href='./css/jQuery/cJnlModalPgProdutos.css' type='text/css' />";
          echo "<script language='JavaScript' src='./js/jQryJanelaModalPgProdutos.js'></script>";
          //arquivo para o plugin jQuery de validação de formulário
          echo "<script language='JavaScript' src='./jQuery/plugin/validation/jquery.validate.js'></script>";
          echo "<script language='JavaScript' src='./jQuery/plugin/alphanumeric.js'></script>";
        echo "</head>";
      }
      
      
	  //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("./classes/metodosGerais.php");
	  }
	  
	  
      private function InicializarVariaveis(){
        //métodos gerais
        $this->FMetGer = MetodosGerais::GetInstanciaMetodosGerais();
      } //fim - InicializarVariaveis()


      //iniciar a tag body
      function IniciarBody(){
        //echo "<body onLoad='IniciarExibicaoProdutos(\"inicio\",\"camiseta\",\"0\");'>";
        echo "<body onLoad='IniciarExibicaoProdutos();'>";
      }
      

      //inicia a div principal do site
      function IniciarDivPrincipal(){
        echo "<div class='divProdutos' name='divProdutos' id='divProdutos'>";
      }

      //cria a div onde será exibido os filtros que o usuário realizou
      function CriarDivFiltro(){
        echo "<div class='divFiltroProdutos' name='divFiltroProdutos' id='divFiltroProdutos'>";
          echo "<span class='spnFiltroRealizado' name='spnFiltroRealizado' id='spnFiltroRealizado'>";
            echo "";
          echo "</span>";
          
          echo "<a href='javascript: IniciarExibicaoProdutos();' class='lnkFecharFiltro' name='lnkFecharFiltro' id='lnkFecharFiltro'>";
            echo "X";
          echo "</a>";

        echo "</div>";
      } //fim - CriarDivFiltro()

      //cria a div que mostra a mensagem que nenhum produto foi encontrado
      private function CriarDivNenhumProduto(){
        echo "<div class='divNenhumProduto' name='divNenhumProduto' id='divNenhumProduto'>";
          echo "Nenhum produto encontrado.";
        echo "</div>";
      } //fim - CriarDivNenhumProduto()
      

      //constrói as div's dos produtos
      function CriarDivProdutos(){
        //for para criar a div do produto - serão 9 produtos por página
        for($i=1; $i<=9; $i++){
        //div do produto
        echo "<div class='divProduto' name='divProduto" .$i. "' id='divProduto" .$i. "'>";
          //div com dados da imagem do produto
          echo "<div class='divDadosImagemProduto' name='divDadosImagemProduto" .$i. "' id='divDadosImagemProduto" .$i. "'>";
            echo "<a class='aLnkFigura' name='aLnkFigura1" .$i. "' id='aLnkFigura1" .$i. "' href='' rel='figuras" .$i. "'>";
              echo "<img class='imgFiguraProduto' name='imgFigura" .$i. "' id='imgFigura" .$i. "' src='' >";
            echo "</a>";
            echo "<a name='aLnkFigura2" .$i. "' id='aLnkFigura2" .$i. "' href='' rel='figuras".$i."'></a>";
            echo "<a name='aLnkFigura3" .$i. "' id='aLnkFigura3" .$i. "' href='' rel='figuras".$i."'></a>";
          echo "</div>"; //fim - div dados da imagem produto

          //div com dados do produto, e opções para compra
          echo "<div class='divDadosCompraProduto' name='divDadosCompraProduto" .$i. "' id='divDadosCompraProduto" .$i. "'>";
            //div com dados do produto
            echo "<div class='divDadosProduto' name='divDadosProduto" .$i. "' id='divDadosProduto" .$i. "'>";
              //nome
              echo "<span class='spnTituloCaracProduto' name='spnTitCaracProdNome" .$i. "' id='spnTitCaracProdNome" .$i. "'>" ."Nome ". "</span>";
              echo "<a href='javascript: ChamarPaginaVisualizarProduto(edTipoProduto".$i.".value, edIdProduto".$i.".value);' class='lnkVisualizarProduto' name='lnkVisualizarProduto" .$i. "' id='lnkVisualizarProduto" .$i. "'>";
                echo "<span class='spnVlrCaracProduto' name='spnVlrCaracProdNome" .$i. "' id='spnVlrCaracProdNome" .$i. "'>";
                echo "</span>";
              echo "</a>";
              echo "<br />";

              //valor
              echo "<span class='spnTituloCaracProduto' name='spnTitCaracProdValor" .$i. "'id='spnTitCaracProdValor" .$i. "'>" ."R$ ". "</span>";
              echo "<span class='spnVlrCaracProduto' name='spnVlrCaracProdValor" .$i. "' id='spnVlrCaracProdValor" .$i. "'>";
              echo "</span>";
              echo "<br />";
              
              //desconto
              echo "<span class='spnTituloCaracProduto' name='spnTitCaracProdDesconto" .$i. "'id='spnTitCaracProdDesconto" .$i. "'>" ."Desconto R$ ". "</span>";
              echo "<span class='spnValorCaracProduto' name='spnVlrCaracProdDesconto" .$i. "' id='spnVlrCaracProdDesconto" .$i. "'>";
              echo "</span>";
              echo "<br />";

              //descrição
              echo "<span class='spnTituloCaracProduto' name='spnTitCaracProdDescricao" .$i. "'id='spnTitCaracProdDescricao" .$i. "'>" ."Descricão ". "</span>";
              echo "<span class='spnVlrCaracProduto' name='spnVlrCaracProdDescricao" .$i. "'id='spnVlrCaracProdDescricao" .$i. "'>";
              echo "</span>";
              echo "<br />";

              //campos id's - hidden
              echo "<input type='hidden' name='edTipoProduto" .$i. "' id='edTipoProduto" .$i. "' value='camiseta' />";
              echo "<input type='hidden' name='edIdProduto" .$i. "' id='edIdProduto" .$i. "' value='' />";
            echo "</div>"; //fim - div com dados do produto

            //div com as opções para a compra do produto
            echo "<div class='divComprarProduto' name='divComprarProduto" .$i. "' id='divComprarProduto" .$i. "'>";
              //xxxxxxxxxxxxxxxxxxxxxxxxxxxx
              echo "<input type='button' class='btnComprarItem' name='btnComprarItem" .$i. "' ";
              echo "id='#janelaComprarProduto' value='' ";
              echo " />";
              //xxxxxxxxxxxxxxxxxxxxxxxxxxxx
            echo "</div>"; //fim - div com as opções para a compra do produto

          echo "</div>"; //fim - div com dados do produto, e opções para compra

        echo "</div>"; //fim - div do produto
        } //fim - for
      }//fim - CriarDivProdutos
      
      
      //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
      //cria a div para comprar produto
      private function CriaDivComprarProduto(){
        echo "<div id='boxes'>";
          echo "<div id='janelaComprarProduto' class='window dialog'>";
            echo "<a href='#' class='close'>Fechar [X]</a>";
            echo "<div class='divDescOpcComprarProduto'>";
              //descrição do produto a ser comprado
              echo "<div class='divDescProdutoComprado' name='divDescProdutoComprado' id='divDescProdutoComprado'>";
                echo "<img class='imgFiguraProdutoComprar' name='imgFiguraProdutoComprar' id='imgFiguraProdutoComprar' src='' />";
                echo "<span class='spnTituloComprarProduto' name='spnTituloComprarProdutoNome' id='spnTituloComprarProdutoNome'>";
                  echo "";
                echo "</span>";
                echo "<br />";
                echo "<span class='spnTituloComprarProduto' name='spnTituloComprarProdutoValor' id='spnTituloComprarProdutoValor'>";
                  echo "";
                echo "</span>";
              echo "</div>";
              
              echo "<div class='divOpcProdutoComprado' name='divOpcProdutoComprado' id='divOpcProdutoComprado'>";
                //formulário para realizar a compra do produto
                echo "<form id='frmComprarProduto' name='frmComprarProduto' method='post' action=''>";
                  echo "<input type='hidden' name='edCdProduto' id='edCdProduto' value='' />";
                  echo "<input type='hidden' name='edTipoProduto' id='edTipoProduto' value='' />";
                  //quantidade
                  echo "<label for='txtCompProdQtde' class='lblTituloCompProd' name='lblTituloCompProdQtde' id='lblTituloCompProdQtde'>";
                    echo "Qtde:";
                  echo "</label>";
                  echo "<input type='text' class='txtCompProd' name='txtCompProdQtde' id='txtCompProdQtde' value='1' maxlength='3'>";
                  echo "<br />";
                  //tamanho
                  echo "<label for='sctTamanho' class='lblTituloCompProd' name='lblTituloCompProdTamanho' id='lblTituloCompProdTamanho'>";
                    echo "Tamanho:";
                  echo "</label>";
                  echo "<select type='text' size='1' class='sctCompProd' name='sctTamanho' id='sctTamanho'>";
//                    echo "<option selected value='' class='sctOptTamanho'></option>";
                    $this->FMetGer->ExibirTamanhos("sctOptTamanho");
                  echo "</select>";
                  echo "<br />";
                  //comprar
                  echo "<input type='submit' class='btnCompProd' name='btnCompProdComprar' id='btnCompProdComprar' value='Comprar' />";
                  echo "<img class='imgComprarProdutoProcessando' name='imgComprarProdutoProcessando' id='imgComprarProdutoProcessando' src='./figuras/processando/loader1.gif' />";
                  echo "<span class='spnInformacaoComprouProduto' name='spnInformacaoComprouProduto' id='spnInformacaoComprouProduto'>";
                     echo "";
                  echo "</span>";
                echo "</form>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
        echo "</div>";
      } //CriaDivComprarProduto()
      //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx


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
      
    } //fim - class PgProdutos
?>
